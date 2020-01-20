<?php
	use Core\Application;
	
	if (!function_exists('e')) {
		/**
		 * Permet d'échapper les balises html
		 * @param string $string La chaine à échapper
		 * @return string $string La chaine échappée
		 */
		function e($string)
		{
			return htmlspecialchars($string);
		}
	}

	/**
	 * Permet d'échapper les balises html
	 * @param string $url
	 * @param string $page
	 * @return string active
	 */
	if (!function_exists('get_active')) {
		function get_active($url, $page, $active_class = 'active')
		{
			if ($url == $page) {
				return $active_class;
			}
		}
	}

	/**
	 * Véririfie si c'est un numéro de téléphone
	 * @param numeric $tel = Le numéro de téléphone à vérifier
	 * @return bool
	 */
	if (!function_exists('is_tel')) {
		function is_tel($tel) {
			if (is_numeric($tel)) {
				if (preg_match('#^\+([1-9]){1}([0-9]){11,14}#', $tel)) {
					return true;
				}

			}
			
			return false;
		}
	}

	/**
	 * Vérifie si le nombre est paire
	 * @param numeric $number = Le nombre à vérifier
	 * @return bool
	 */
	if (!function_exists('is_paire')) {
		function is_paire($number) {
			return !is_float($number / 2) ? true : false;
		}
	}

	/**
	 * Permet de générer un lien
	 * @param string $route = La route
	 * @return string $lien = Le lien généré
	 */
	if (!function_exists('lien')) {
		function lien($route)
		{
			return $_SERVER['REQUEST_URI'].'/'.$route;
		}
	}


	if (!function_exists('parse_slug')) {
		function parse_slug($slug) {
			$new_slug = strtolower($slug);
			$new_slug = preg_replace('# #', '-', $new_slug);
			$new_slug = preg_replace('#é#', 'e', $new_slug);
			$new_slug = preg_replace('#è#', 'e', $new_slug);
			$new_slug = preg_replace('#à#', 'a', $new_slug);
			$new_slug = preg_replace('#â#', 'a', $new_slug);
			$new_slug = preg_replace('#ê#', 'e', $new_slug);
			$new_slug = preg_replace('#û#', 'u', $new_slug);
			$new_slug = preg_replace('#ü#', 'u', $new_slug);
			$new_slug = preg_replace('#ï#', 'i', $new_slug);
			$new_slug = preg_replace('#î#', 'i', $new_slug);
			$new_slug = preg_replace('#ä#', 'a', $new_slug);
			$new_slug = preg_replace('#ë#', 'e', $new_slug);
			$new_slug = preg_replace('#ô#', 'o', $new_slug);
			$new_slug = preg_replace('#ö#', 'o', $new_slug);
			$new_slug = preg_replace("#'#", '-', $new_slug);

			return $new_slug;
		}
	}

	if (!function_exists('unparse_slug')) {
		function unparse_slug($slug) {
			return ucfirst(preg_replace('#-#', ' ', $slug));
		}
	}

	if (!function_exists('debug')) {
		/**
		 * Permet de faire un debug sur la variable passée en paramètre
		 * @param void $data
		 * @return void
		 */
		function debug($data)
		{
			echo "<pre>";
			print_r($data);
			echo "</pre>";
			die();
		}
	}

	if (!function_exists('dump')) {
		function dump($data) {
			var_dump($data);
			die();
		}
	}

	if (!function_exists('mois')) {
		function mois($mois) {
			switch ($mois) {
				case '01':
					$mois = 'Janvier';
					break;
				case '02':
					$mois = 'Fevrier';
					break;
				case '03':
					$mois = 'Mars';
					break;
				case '04':
					$mois = 'Avril';
					break;
				case '05':
					$mois = 'Mai';
					break;
				case '06':
					$mois = 'Juin';
					break;
				case '07':
					$mois = 'Juillet';
					break;
				case '08':
					$mois = 'Aout';
					break;
				case '09':
					$mois = 'Septembre';
					break;
				case '10':
					$mois = 'Octobre';
					break;
				case '11':
					$mois = 'Novembre';
					break;
				case '12':
					$mois = 'Decembre';
					break;

				default:
					return false;
					break;

			}
			
			return $mois;
		}
	}

	if (!function_exists('format_date')) {
		/**
		 * Permet de formater une date par le format "01 Janvier 2019"
		 * @param \DateTime $date La date à formater
		 * @return string La date formatée
		 */
		function format_date(DateTime $date) {
			$jour = $date->format('d');
			$mois = mois($date->format('m'));
			$annee = $date->format('Y');

			return $jour . ' ' . $mois . ' ' . $annee;
		}
    }
    
    /**
     * Permet d'envoyer des données sous format json
     * @param mixed $value
	 * @param string|int $status
     */
    function send($value, $status = null) {
		header('Content-Type: application/json');
		
		if ($status) {
			header('HTTP/1.0 '.$status);
		}

        echo \json_encode($value);
        die();
	}
	
	/**
	 * Permet de rendre les clés d'un tableau en des constantes
	 * @param array $array Le tableau à extraire
	 */
	function keys_array_to_constantes(array $array) {
		foreach ($array as $key => $value) {
			define($key, $value);
		}
	}

	if (!function_exists('config')) {
		/**
		 * Permet de renvoyer une configuration ou les tableaux de toutes les configuration
		 * @param string $conf La configuration à trouver
		 */
		function config(string $conf) {
			$basePath = app()::basePath();

			// $config = preg_replace('#\.#', DIRECTORY_SEPARATOR, $conf);
			$config = preg_match('#\.#', $conf) ? explode('.', $conf) : $conf;
			$fileConf = is_array($config) ? $config[0] : $config;
			$filenameConf = $basePath.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.$fileConf.'.php';

			$data = require $filenameConf;

			return is_array($config) ? $data[$config[1]] : $data;
		}
	}

	if (!function_exists('app')) {
		/**
		 * Helper pour l'application, revnoi l'instance de l'application
		 */
		function app () {
			return new Application;
		}
	}

	if (!function_exists('console_log')) {
		/**
		 * Permet d'afficher les données à la console à l'aide de print_r
		 * @param $data Les données à afficher
		 * @param bool $die S'il faut arrêter le script ou pas
		 */
		function console_log($data, $die = true) {
			print_r($data);

			$die ? die() : '';
		}
	}

	if (!function_exists('make_cmd_space')) {
		/**
		 * Permet de mettre de l'espace entre une commande et sa description
		 * @param $command
		 */
		function make_cmd_space($command) {
			$result = $command;

			while (mb_strlen($result) < 30) {
				$result .= " ";
			}

			return $result;
		}
	}