<?php
	namespace Core\Console;

	/**
	 * Permet de gérer les commandes
	 */
	class Commands implements CommandsInterface
	{
		/**
		 * Permet de créer un fichier de la fonctionnalité voulant mettre en place
		 * @param string $folder Le dossier où sera logé le fichier en question
		 * @param string $filename Le nom du fichier à créer
		 * @param $content Le contenu à insérer dans le fichier à créer
		 * @return bool
		 */
		public function make(string $folder, string $filename, $content)
		{
			$filename 	= $folder.DS.$filename;
			$directory 	= !file_exists($folder) ? mkdir($folder, 0755, true) : $folder;
			$file_open  = fopen($filename, 'w');
			$file_write = fwrite($file_open, $content);

			return (bool) $file_write;
		}
	}
