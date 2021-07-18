<?php

class Table
{
   private static $_instance;
   protected $table_attribute = [];
   protected $db;
   private $called_class = [];
   private $class_list_names = [];

   function __construct()
   {
      $this->db = Database::getInstance();
   }

   static function getInstance()
   {
      if (is_null(self::$_instance)) {
         self::$_instance = new Table();
         return self::$_instance;
      }
      return self::$_instance;
   }

   function get(string $table_name):Table
   {
      if (!in_array($table_name, array_keys($this->called_class))) {
         #je recupere le nom final de ma table
         $table = strtolower($table_name) . $table_name;
         #je verifie si le nom de la classe existe dans le taleau des noms
         $nom = trim(strtolower($table_name));
         $nom .= "Table";
         try {
            $table = new $nom($this->getDb());
         } catch (Exception $e) {
            die("Erreur lors du chargement de la classe");
         }
         #je l'ajoute a la liste des table
         $this->called_class[$table_name] = $table;
         return $this->called_class[$table_name];
      } else {
         return $this->called_class[$table_name];
      }
   }

   function getDb()
   {
      return $this->db;
   }

   function query(string $type, string $table_name,  String|array $settings, string $clause)
   {
      if (strtolower($type) == "insert") {
         if ($this->keysMatched($settings)) {
            $res = true;
            $keys = array_combine(array_keys($settings), array_values($settings));
            $sql = "INSERT INTO  $table_name set ";
            foreach ($keys as $key => $value) {
               if (is_string($value) and $value != "NOW()" and strtolower($value) != "null") {
                  $sql .= "$key = '$value',";
               } else {
                  $sql .= "$key = $value,";
               }
            }
            $sql = substr($sql, 0, -1);
            #je recupere le pdo de ma base de donnes
            return $sql;
         } else {
            die("Erreur les clé passe en parametre doivent correspondre aux champs
                        de la table " . __FILE__ . " " . __LINE__);
         }
      } else if (strtolower($type) == "update") {
         if ($this->keysMatched($settings)) {
            $res = true;
            $keys = array_combine(array_keys($settings), array_values($settings));
            $sql = "UPDATE $table_name set ";
            foreach ($keys as $key => $value) {
               if (is_string($value) and $value != "NOW()" and strtolower($value) != "null") {
                  $sql .= "$key = '$value',";
               } else {
                  $sql .= "$key = $value,";
               }
            }
            $sql = substr($sql, 0, -1);
            $sql .= "  {$clause} ";
            #je recupere le pdo de ma base de donnes
            return $sql;
         } else {
            die("Erreur les clé passe en parametre doivent correspondre aux champs
                        de la table " . __FILE__ . " " . __LINE__);
         }
      } else if (strtolower($type) == "select") {
         $sql = "SELECT ";
         if (is_array($settings)) {
            #je verifi d'abord si les cles existe
            foreach ($settings as $keys => $value) {
               if (!in_array($value, $this->table_attribute)) {
                  throw new Exception("Erreur");
               }else
                  $sql .= "$value,";
            }
            $sql = substr($sql, 0, -1);

         } else {
            $sql .= "$settings";
         }
         $sql .= " FROM $table_name  {$clause} ";
         return $sql;
      } else {
         $sql = "DELETE FROM $table_name  $clause";
         return $sql;
      }
   }

   function keysMatched(array $keys): bool
   {
      $result = true;
      foreach (array_keys($keys) as $key => $value) {
         if (!in_array($value, $this->table_attribute)) {
            $result = false;
         }
      }
      return $result;
   }


}
