<?php 
	namespace Core;

	use App\Config\DB;

	/**
	 * Le model principal
	 */
	class Model
	{
		static $connections = [];
		protected $req = [];
		protected $table;
		protected $db;
		protected $primaryKey = 'id';
		protected $conf = 'default';

		/**
		 * Charge l'instance de l'objet Conf et l'objet PDO de la BDD
		 * @return void
		 */
		public function __construct()
		{
			// $this->dbConnexion();
		}

		public function dbConnexion()
		{
			// Connexion à la base de données
			$conf = DB::$databases[$this->conf];

			try {
				$pdo = new \PDO('mysql:host='.$conf['host'].';dbname='.$conf['database'], 
					$conf['login'], 
					$conf['password'],
					[\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']
				);
				$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
				self::$connections[$this->conf] = $pdo;
				$this->db = $pdo;
				
			} catch (\PDOException $e) {
				if (DB::$debug >= 1) {
					die($e->getMessage());
				}else{
					die('Impossible de se connecter à la base de données.');
				}
			}
		}

		/**
		 * Permet de supprimer une entrée dans une table
		 * @param $data
		 * @return void
		 */
		public function delete($req, $table = null)
		{
			if ($table) {
				$this->table = $table;
			}

			if (!empty($req)) {
				$sql = 'DELETE FROM '.$table;

				if ($req['cond']) {
					$sql .= ' WHERE '.$req['cond'];
				}

				$req = $this->db->prepare($sql);
				$req->execute();
			}
		}

		/**
		 * Permet d'ajouter un enregistrement dans une table
		 * @param $donnees array = Le tableau contenant les données qu'il faut ajouter
		 * @return true bool
		 */
		public function add($donnees, $table = null)
		{
			if ($table) {
				$this->table = $table;
			}

			if (!is_array($donnees)) {
				throw new Exception('La variable $donnees dans la methode Model::add() doit être un tableau associatif');
			}else{
				$fields = $values = $q = [];
				foreach ($donnees as $key => $value) {
					$fields[] = $key;
					$values[":$key"] = $value;
				}

				for ($i=0; $i < count($fields); $i++) { 
					$q[] = str_replace($fields[$i], ':'.$fields[$i], $fields[$i]);
				}

				$str_fields = implode(',', $fields);
				$str_q		= implode(',', $q);

				$sql = 'INSERT INTO '.$this->table.'('.$str_fields.') VALUES('.$str_q.')';
				// debug($sql);

				$req = $this->db->prepare($sql);
				$req->execute($values);

				return $this->lastInsert();
			}
		}

		/**
		 * Modifie un ou plusieurs enregistrements
		 * @param $data array = Les données à modifier
		 * @return true bool
		 */
		public function update($data, $table = null)
		{
			if ($table) {
				$this->table = $table;
			}

			$key = $this->primaryKey;
			$fields = $d = [];
			foreach ($data as $k => $v) {
				if ($k !== $this->primaryKey) {
					$fields[] = "$k=:$k";
				}
				
				$d[":$k"] = $v; 
			}

			$sql = 'UPDATE '.$this->table.' SET '.implode(',', $fields).' WHERE '.$key.'=:'.$key;

			$req = $this->db->prepare($sql);
			$req->execute($d);

			return true;
		}

		/**
		 * Permet de récuperer des infos dans la table
		 * @param $req array = Les req pour récuperer
		 * @return $data = Les données trouvées
		 */
		public function find($req = [], $table = null)
		{
			if ($table) {
				$this->table = $table;
			}

			$sql = 'SELECT ';

			$sql .= isset($req['champs']) ? $req['champs'].' ' : '* ';
			$sql .= 'FROM ' . $this->table .' ';
			$sql .= isset($req['cond']) ? 'WHERE '.$req['cond'] : '';
			$sql .= isset($req['limit']) ? ' LIMIT '.$req['limit'] : '';

			// debug($sql);

			$req = $this->db->prepare($sql);
			$req->execute();
			
			if ($req) {
				return $req->fetchAll(\PDO::FETCH_OBJ);
			}

			return false;
		}

		/**
		 * Recherche tous les enregistrements
		 */
		public function findAll($req = [], $table = null)
		{
			return $this->find($req, $table);
		}

		/**
		 * Permet de récuperer seulement un enregistrement
		 * @param $req = Les req qu'il faut
		 * @return $data = les données trouvées
		 */
		public function findOne($req, $table = null)
		{
			return $this->find($req, $table) 
				   ? current($this->find($req, $table)) 
				   : false;
		}

		/**
		 * Recherche par rapport à l'id de cet enregistrement
		 * @param {*} $id L'id de cet enregistrement
		 * @param {String} $table La table où on fait cette recherche
		 */
		public function findById($id, $table = null)
		{
			return $this->find(['cond' => 'id='.$id], $table);
		}
		
		/**
		 * Permet de compter le nombre des enregistremetns
		 * @param {Array} $req Les contraintes de la recherche des enregistrements
		 * @param {String} $table La table
		 */
		public function count($req = [], $table = null)
		{
			return count($this->find($req, $table));
		}

		public function setTable($table)
		{
			$this->table = $table;
		}

		public function table()
		{
			return $this->table;
		}

		public function setPrimaryKey($key)
		{
			$this->primaryKey = $key;
		}

		public function primaryKey()
		{
			return $this->primaryKey;
		}

		/**
		 * Renvoi la dernière entrée dans la base de données
		 */
		public function lastInsert()
		{
			return $this->findOne(['cond' => 'id='.$this->db->lastInsertId()]);
		}
	}