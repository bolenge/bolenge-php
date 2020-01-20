<?php 
	namespace Core;

	/**
	 * Gère comment envoyer les différentes requêtes http vers l'API
	 */
	class APIRequest
	{
        /**
         * Permet de lancer une requête post vers l'API
         * @param string $url L'url à demander les ressources
         * @param array $data Les données à envoyer
         * @param function $callback
         */
        public static function post(string $url, array $data, $vars = null, $callback = null)
        {
            $curl = curl_init($url);

            // CURLOPT_TIMEOUT		   => 5,
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS     => $data
            ]);

            $response = curl_exec($curl);

            if ($response === false || curl_getinfo($curl, CURLINFO_HTTP_CODE) !== 200) {
                $response = null;
            }
            
            curl_close($curl);

            $result = json_decode($response);

            if ($callback !== null) {
                return $callback($result, $vars);
            }else {
                return $result;
            }
        }

        /**
         * Permet de lancer une requête post vers l'API en envoyant un fichier
         * @param string $url L'url à demander les ressources
         * @param array $data Les données à envoyer
         */
        public static function postFile(string $url, array $data)
        {
            $curl = curl_init($url);
            $file_handle = \fopen($data['file'], 'r');

            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT	=> 5,
                CURLOPT_UPLOAD  => 1,
                CURLOPT_INFILE => $file_handle,
                CURLOPT_INFILESIZE => $data['file_size'],
                CURLOPT_VERBOSE=> true,
            ]);

            $response = curl_exec($curl);

            if ($response === false || curl_getinfo($curl, CURLINFO_HTTP_CODE) !== 200) {
                $response = null;
            }
            
            curl_close($curl);
            
            return json_decode($response);
        }

        /**
         * Permet de lancer une requête get vers l'API
         * @param string $url L'url à demander les données
         */
        public static function get(string $url, $callback = null, $vars = null)
        {
            $curl = curl_init($url);

            // debug($url);
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => true
            ]);

            $data = curl_exec($curl);

            if ($data === false || curl_getinfo($curl, CURLINFO_HTTP_CODE) !== 200) {
                $data = null;
            }

            curl_close($curl);
            
            if ($callback !== null) {
                // debug(json_decode($data));
                return $callback(json_decode($data), $vars);
            }else {
                return json_decode($data);
            }
        }

        /**
         * Permet de lancer une requête PUT vers l'API
         * @param string $url L'url à lancer la requête
         * @param array $data Les données à envoyer
         * @param function $callback
         */
        public static function put(string $url, array $data = null, $mbContent = false, $vars = null, $callback = null)
        {
            if ($mbContent) {
                $content = stream_context_create([
                    'http' => [
                        'method' => 'PUT',
                        'header' => [
                            'Accept: application/json',
                            'Content-Type: application/x-www-form-urlencoded'
                        ],
                        'content' => http_build_query($data)
                    ]
                ]);
            }else {
                $content = stream_context_create([
                    'http' => [
                        'method' => 'PUT',
                        'header' => [
                            'Accept: application/json',
                            'Content-Type: application/x-www-form-urlencoded',
                            'Content: '.json_encode($data)
                        ]
                    ]
                ]);
            }

            $result = file_get_contents($url, false, $content);
            $reponse = json_decode($result);

            $callback($reponse, $vars);
        }

        /**
         * Permet de lancer une requête DELETE (de suppression) vers l'API
         * @param string $url L'url à lancer la requête
         * @param array $vars Les variables à passer dans la callback
         * @param function $callback
         */
        public static function delete(string $url, $data = null, $mbContent = false, $vars = null, $callback = null)
        {
            if ($mbContent) {
                $content = stream_context_create([
                    'http' => [
                        'method' => 'DELETE',
                        'header' => [
                            'Accept: application/json',
                            'Content-Type: application/x-www-form-urlencoded'
                        ],
                        'content' => http_build_query($data)
                    ]
                ]);
            }else {
                $content = stream_context_create([
                    'http' => [
                        'method' => 'DELETE',
                        'header' => [
                            'Accept: application/json',
                            'Content-Type: application/x-www-form-urlencoded',
                            'Content: '.json_encode($data)
                        ]
                    ]
                ]);
            }

            $result = file_get_contents($url, false, $content);
            $reponse = json_decode($result);

            if (!empty($callback)) {
                $callback($reponse, $vars);
            }else {
                return $reponse;
            }
            
        }
    }