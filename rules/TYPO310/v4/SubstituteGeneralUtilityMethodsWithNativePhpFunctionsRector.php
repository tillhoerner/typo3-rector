<?php

declare(strict_types=1);

namespace Ssch\TYPO3Rector\TYPO310\v4;

use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp\Mul;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Scalar\Int_;
use PHPStan\Type\ObjectType;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @changelog https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/10.4/Deprecation-91001-VariousMethodsWithinGeneralUtility.html
 * @see \Ssch\TYPO3Rector\Tests\Rector\v10\v4\SubstituteGeneralUtilityMethodsWithNativePhpFunctionsRector\SubstituteGeneralUtilityMethodsWithNativePhpFunctionsRectorTest
 */
final class SubstituteGeneralUtilityMethodsWithNativePhpFunctionsRector extends AbstractRector implements DocumentedRuleInterface
{
    /**
     * @var string[]
     */
    private const METHOD_CALL_TO_REFACTOR = ['IPv6Hex2Bin', 'IPv6Bin2Hex', 'compressIPv6', 'milliseconds'];

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

        if (! $this->isNames($node->name, self::METHOD_CALL_TO_REFACTOR)) {
            return null;
        }

        $nodeName = $this->getName($node->name);

        if ($nodeName === 'IPv6Hex2Bin') {
            return $this->nodeFactory->createFuncCall('inet_pton', $node->args);
        }

        if ($nodeName === 'IPv6Bin2Hex') {
            return $this->nodeFactory->createFuncCall('inet_ntop', $node->args);
        }

        if ($nodeName === 'compressIPv6') {
            return $this->nodeFactory->createFuncCall(
                'inet_ntop',
                [$this->nodeFactory->createFuncCall('inet_pton', $node->args)]
            );
        }

        if ($nodeName === 'milliseconds') {
            return $this->nodeFactory->createFuncCall('round', [
                new Mul($this->nodeFactory->createFuncCall(
                    'microtime',
                    [$this->nodeFactory->createArg($this->nodeFactory->createTrue())]
                ), new Int_(1000)),
            ]);
        }

        return null;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Substitute deprecated method calls of class GeneralUtility',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
use TYPO3\CMS\Core\Utility\GeneralUtility;

$hex = '127.0.0.1';
GeneralUtility::IPv6Hex2Bin($hex);
$bin = $packed = chr(127) . chr(0) . chr(0) . chr(1);
GeneralUtility::IPv6Bin2Hex($bin);
$address = '127.0.0.1';
GeneralUtility::compressIPv6($address);
GeneralUtility::milliseconds();
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
use TYPO3\CMS\Core\Utility\GeneralUtility;

$hex = '127.0.0.1';
inet_pton($hex);
$bin = $packed = chr(127) . chr(0) . chr(0) . chr(1);
inet_ntop($bin);
$address = '127.0.0.1';
inet_ntop(inet_pton($address));
round(microtime(true) * 1000);
CODE_SAMPLE
                ),
            ]
        );
    }
}
