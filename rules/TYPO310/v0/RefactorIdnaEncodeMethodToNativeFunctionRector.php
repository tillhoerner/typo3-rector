<?php

declare(strict_types=1);

namespace Ssch\TYPO3Rector\TYPO310\v0;

use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp\Concat;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar\String_;
use PHPStan\Type\ObjectType;
use Rector\PhpParser\Node\Value\ValueResolver;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @changelog https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/10.0/Deprecation-87894-GeneralUtilityidnaEncode.html
 * @see \Ssch\TYPO3Rector\Tests\Rector\v10\v0\RefactorIdnaEncodeMethodToNativeFunctionRector\RefactorIdnaEncodeMethodToNativeFunctionRectorTest
 */
final class RefactorIdnaEncodeMethodToNativeFunctionRector extends AbstractRector implements DocumentedRuleInterface
{
    /**
     * @readonly
     */
    private ValueResolver $valueResolver;

    public function __construct(ValueResolver $valueResolver)
    {
        $this->valueResolver = $valueResolver;
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [StaticCall::class];
    }

    /**
     * @param StaticCall $node
     */
    public function refactor(Node $node): ?Node
    {
        if (! $this->nodeTypeResolver->isMethodStaticCallOrClassMethodObjectType(
            $node,
            new ObjectType('TYPO3\CMS\Core\Utility\GeneralUtility')
        )) {
            return null;
        }

        if (! $this->isName($node->name, 'idnaEncode')) {
            return null;
        }

        $arguments = $node->args;
        if ($arguments === []) {
            return null;
        }

        $firstArgumentValue = $this->valueResolver->getValue($arguments[0]->value);
        if (! is_string($firstArgumentValue)) {
            return null;
        }

        if (! str_contains($firstArgumentValue, '@')) {
            return $this->refactorToNativeFunction($firstArgumentValue);
        }

        return $this->refactorToEmailConcatWithNativeFunction($firstArgumentValue);
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Use native function `idn_to_ascii` instead of `GeneralUtility::idnaEncode()`', [
            new CodeSample(
                <<<'CODE_SAMPLE'
$domain = GeneralUtility::idnaEncode('domain.com');
$email = GeneralUtility::idnaEncode('email@domain.com');
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
$domain = idn_to_ascii('domain.com', IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46);
$email = 'email@' . idn_to_ascii('domain.com', IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46);
CODE_SAMPLE
            ),
        ]);
    }

    private function refactorToNativeFunction(string $value): FuncCall
    {
        return $this->nodeFactory->createFuncCall(
            'idn_to_ascii',
            [new String_($value), new ConstFetch(new Name('IDNA_DEFAULT')), new ConstFetch(new Name(
                'INTL_IDNA_VARIANT_UTS46'
            ))]
        );
    }

    private function refactorToEmailConcatWithNativeFunction(string $value): Concat
    {
        [$email, $domain] = explode('@', $value, 2);
        return new Concat(new String_($email . '@'), $this->refactorToNativeFunction($domain));
    }
}
