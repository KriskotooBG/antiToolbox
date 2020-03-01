<?php
	namespace kriskotooBG\AntiToolbox;
	
	
	use pocketmine\utils\Config;
	use pocketmine\utils\TextFormat as TF;
	
	use kriskotooBG\AntiToolbox\Main;
	
  
	
	
	class ConfigManager{
		public const CONF_VER = 1.0;
		
		
		public function __construct(Main $plugin){
			$this->plugin = $plugin;
		}
		
		
		
		
		
		public function saveDefaultAssets(){
			@mkdir($this->plugin->getDataFolder());
			$this->plugin->saveResource("config.yml");
			$this->conf = new Config($this->plugin->getDataFolder() . "config.yml", Config::YAML);
		}
		
		
		
		public function reloadConfigFile(){
			$this->conf = new Config($this->plugin->getDataFolder() . "config.yml", Config::YAML);
		}
		
		
		
		public function checkConfVersion(){
			if($this->conf->exists("confVer") && $this->conf->get("confVer") == self::CONF_VER){
				$this->plugin->getLogger()->info(TF::GREEN . "Configuration file loaded successfully!");
			}
			else{
				rename($this->plugin->getDataFolder() . "config.yml", $this->plugin->getDataFolder() . "config_old_version.yml");
				
				$this->plugin->saveResource("config.yml");
				$this->reloadConfigFile();
				$this->plugin->getLogger()->critical("Didn't find config value 'configVersion' OR config version is outdated! Required config version: " . self::CONF_VER);
				$this->plugin->getLogger()->warning("The old configuration file has been renamed to config_old_version.yml and a new configuration file has been created.");
			}
		}
		
		
		
		public function get(string $item, bool $reload = false){
			if($reload === true){
				$this->reloadConfigFile();
			}
			
			return $this->conf->get($item);
		}
	}
?>
