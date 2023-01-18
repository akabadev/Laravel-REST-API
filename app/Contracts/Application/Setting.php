<?php

namespace App\Contracts\Application;

final class Setting
{
    /**
     * @var array $settings
     */
    private array $settings = [];

    /**
     * @var self|null $instance
     */
    private static ?self $instance = null;

    /**
     * @var bool $loaded
     */
    private bool $loaded = false;

    private function __construct()
    {
    }

    /**
     * @return bool
     */
    public function isLoaded(): bool
    {
        return $this->loaded && count($this->settings) > 0;
    }

    /**
     * @return Setting
     */
    public static function getInstance(): Setting
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param string $config
     * @param bool $force
     * @return Setting
     */
    public function load(string $config = "default.json", bool $force = false): self
    {
        if ($this->isLoaded() && !$force) {
            return $this;
        }

        $this->loaded = true;
        $this->settings = [];

        return $this->merge(client_config("settings/$config"));
    }

    /**
     * @param $key
     * @param $value
     * @param bool $overwrite
     * @return $this
     */
    public function put($key, $value, bool $overwrite = true): self
    {
        data_set($this->settings, $key, $value, $overwrite);

        return $this;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->settings;
    }

    /**
     * @param array $settings
     * @return Setting
     */
    public function merge(array $settings = []): self
    {
        $this->settings = array_merge_recursive($this->all(), $settings);

        return $this;
    }

    /**
     * @param string|array|int|null $key
     * @param mixed|null $default
     * @return mixed
     */
    public function valueOf(string|array|int|null $key, mixed $default = null): mixed
    {
        if (!$this->isLoaded()) {
            $this->load();
        }

        return data_get($this->settings, $key, $default);
    }
}
