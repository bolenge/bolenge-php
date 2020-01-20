<?php
	namespace Core\Console;

	/**
	 * CommandsInterface
	 */
	interface CommandsInterface
	{
		/**
		 * Permet de créer l'élément demanders
		 */
		public function make(string $folder, string $filename, $content);
	}