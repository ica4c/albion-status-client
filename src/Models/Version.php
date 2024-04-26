<?php

declare(strict_types=1);

namespace Albion\Status\Models;

class Version
{
    public function __construct(
        protected ?string $windows = null,
        protected ?string $linux = null,
        protected ?string $osx = null,
        protected ?string $android = null,
        protected ?string $ios = null
    ) {
    }

    public function getWindows(): ?string
    {
        return $this->windows;
    }

    public function getLinux(): ?string
    {
        return $this->linux;
    }

    public function getOSX(): ?string
    {
        return $this->osx;
    }

    public function getAndroid(): ?string
    {
        return $this->android;
    }

    public function getIOS(): ?string
    {
        return $this->ios;
    }

    public function isSame(Version $version): bool
    {
        return $this->getOSX() === $version->getOSX() &&
            $this->getLinux() === $version->getLinux() &&
            $this->getWindows() === $version->getWindows() &&
            $this->getIOS() === $version->getIOS() &&
            $this->getAndroid() === $version->getAndroid();
    }
}
