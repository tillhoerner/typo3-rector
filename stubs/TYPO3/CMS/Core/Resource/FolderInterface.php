<?php

namespace TYPO3\CMS\Core\Resource;

if (interface_exists('TYPO3\CMS\Core\Resource\FolderInterface')) {
    return;
}

interface FolderInterface extends ResourceInterface
{
    /**
     * Roles for folders
     */
    public const ROLE_DEFAULT = 'default';
    public const ROLE_RECYCLER = 'recycler';
    public const ROLE_PROCESSING = 'processing';
    public const ROLE_TEMPORARY = 'temporary';
    public const ROLE_USERUPLOAD = 'userupload';
    public const ROLE_MOUNT = 'mount';
    public const ROLE_READONLY_MOUNT = 'readonly-mount';
    public const ROLE_USER_MOUNT = 'user-mount';

    /**
     * @return array<string|int, Folder>
     */
    public function getSubfolders();

    /**
     * Returns the object for a subfolder of the current folder, if it exists.
     *
     * @param string $name Name of the subfolder
     * @return Folder
     */
    public function getSubfolder($name);

    /**
     * Checks if a folder exists in this folder.
     *
     * @param string $name
     * @return bool
     */
    public function hasFolder($name);

    /**
     * Checks if a file exists in this folder
     *
     * @param string $name
     * @return bool
     */
    public function hasFile($name);

    /**
     * Fetches a file from a folder, must be a direct descendant of a folder.
     *
     * @return File|ProcessedFile|null
     */
    public function getFile(string $fileName);

    /**
     * Renames this folder.
     *
     * @param string $newName
     * @return Folder
     */
    public function rename($newName);

    /**
     * Deletes this folder from its storage. This also means that this object becomes useless.
     *
     * @return bool TRUE if deletion succeeded
     */
    public function delete();

    /**
     * Returns the modification time of the folder as Unix timestamp
     *
     * @return int
     */
    public function getModificationTime();

    /**
     * Returns the creation time of the folder as Unix timestamp
     *
     * @return int
     */
    public function getCreationTime();
}
