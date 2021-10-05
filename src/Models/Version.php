<?php

namespace Albion\Status\Models;

class Version
{
    protected $windows;
    protected $linux;
    protected $osx;
    protected $android;
    protected $ios;

    public function getWindows(): ?string
    {
        return $this->windows;
    }

    public function setWindows(?string $windows): self
    {
        $this->windows = $windows;
        return $this;
    }

    public function getLinux(): ?string
    {
        return $this->linux;
    }

    public function setLinux(?string $linux): self
    {
        $this->linux = $linux;
        return $this;
    }

    public function getOSX(): ?string
    {
        return $this->osx;
    }

    public function setOSX(?string $osx): self
    {
        $this->osx = $osx;
        return $this;
    }

    public function getAndroid(): ?string
    {
        return $this->android;
    }

    public function setAndroid(?string $android): self
    {
        $this->android = $android;
        return $this;
    }

    public function getIOS(): ?string
    {
        return $this->ios;
    }

    public function setIOS(?string $ios): self
    {
        $this->ios = $ios;
        return $this;
    }
}