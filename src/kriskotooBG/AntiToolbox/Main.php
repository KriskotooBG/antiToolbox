<?php
	namespace kriskotooBG\AntiToolbox;
	
	
	use pocketmine\plugin\PluginBase;
	use pocketmine\utils\TextFormat as TF;
	use pocketmine\event\Listener;
	use pocketmine\event\server\DataPacketReceiveEvent;
	use pocketmine\network\mcpe\protocol\LoginPacket;

	
	class Main extends PluginBase implements Listener{
		
		public function onEnable(){
			$this->getLogger()->info(TF::GOLD . "---------- AntiToolbox -----------");
			
			if(isset(explode("_", $this->getDescription()->getVersion())[1]) && explode("_", $this->getDescription()->getVersion())[1] == "BETA-PRERELEASE"){
				$this->getLogger()->warning(TF::RED . "You are using a beta version of this plugin!");
				$this->getLogger()->warning(TF::RED . "Errors and/or crashes may occur!");
			}
			
			
			$this->cm = new ConfigManager($this);
			$this->cm->saveDefaultAssets();
			$this->cm->checkConfVersion();
			
			
			$this->getLogger()->info(TF::GREEN . "AntiToolbox loaded successfully!");
			$this->getLogger()->info(TF::GOLD . "---------------------------------");
		}
		
		
		
		
		public function onReceive(DataPacketReceiveEvent $evnt){
			if ($evnt->getPacket() instanceof LoginPacket){
				if ($evnt->getPacket()->clientId === 0){
					
					$evnt->setCancelled(true);
					$evnt->getPlayer()->close('', $this->cm->get("kickMessage", false));
				}
			}
		}
	}
?>
