<?php

namespace natof\utils\lang;

use natof\HoneyParty;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use Symfony\Component\Filesystem\Path;

class LangManager
{
    const PREFIX = TextFormat::BOLD . TextFormat::GOLD . "[" . TextFormat::AQUA . "HoneyParty" . TextFormat::GOLD . "] " . TextFormat::RESET;
    private static $langConfig;

    public static function loadLang()
    {
        $config = new Config(Path::join(HoneyParty::getInstance()->getDataFolder(), "config.yml"), Config::YAML);

        $lang = $config->get("language", "en");
        $langs = $config->get("languages");

        if (!isset($langs[$lang])) {
            HoneyParty::getInstance()->getLogger()->warning("Language not supported: " . $lang);
            return;
        }

        $langPath = HoneyParty::getInstance()->getDataFolder() . $langs[$lang]["path"];
        if (!file_exists($langPath)) {
            HoneyParty::getInstance()->getLogger()->warning("Language file not found: " . $langPath);
        }

        self::$langConfig = new Config($langPath, Config::YAML);
    }

    public static function getMessage(string $key, array $replacements = []): string
    {
        if (self::$langConfig === null) {
            return TextFormat::RED . "Language configuration not loaded.";
        }

        $message = self::$langConfig->get($key, "Message not found: " . $key);
        foreach ($replacements as $placeholder => $value) {
            $message = str_replace("{" . $placeholder . "}", $value, $message);
        }

        return $message;
    }

    public static function getErrorMessage(string $message)
    {
        return self::PREFIX . TextFormat::RED . $message;
    }

    public static function getSuccesMessage(string $message)
    {
        return self::PREFIX . TextFormat::GREEN . $message;
    }
}