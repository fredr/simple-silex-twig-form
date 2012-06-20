<?php
/**
 * Author: Fredrik Enestad @ Devloop AB (fredrik@devloop.se)
 * Date: 2012-06-20
 * Time: 08:33
 */

require_once __DIR__."/IModel.php";

class Program implements IModel
{
    public $id;
    public $date;
    public $time;
    public $leadText;
    public $name;
    public $bLine;
    public $synopsis;
    public $url;

    private $minutesFromMidnight;
    private $dateAsDateAsDatetime;


    private $database;

    function __construct($database) {
        $this->database = $database;
    }


    /**
     * Persists this program to the database
     */
    public function persist() {
        return $this->database->insert("program", array(
            "date"      => $this->dateAsDateAsDatetime,
            "time"      => $this->minutesFromMidnight,
            "leadText"  => $this->leadText,
            "name"      => $this->name,
            "bLine"     => $this->bLine,
            "synopsis"  => $this->synopsis,
            "url"       => $this->url,
        ));
    }

    /**
     * Load a record from db
     */
    public function load($id) {
        $result = $this->database->fetchAll("SELECT `date`, `time`, `leadText`, `name`, `bLine`, `synopsis`, `url`
                                                     FROM `program` WHERE `id` = ? LIMIT 1;",
                                            array(
                                                $id,
                                            )
        );

        $program = (count($result) == 1 ? $result[0] : NULL);

        // if we didn't fetch anything, return false
        if ($program == NULL) return false;

        $this->id = $id;
        $this->date = $program["date"];
        $this->time = $program["time"];
        $this->leadText = $program["leadText"];
        $this->name = $program["name"];
        $this->bLine = $program["bLine"];
        $this->synopsis = $program["synopsis"];
        $this->url = $program["url"];

        return true;
    }

    /**
     * Remove currently loaded entity from db
     */
    public function remove() {
        $this->database->delete("program", array("id" => $this->id));
    }

    /**
     * Checks the input
     * @return array with errors
     */
    public function validate() {
        $errors = array();

        $date = strtotime($this->date);
        if (!$date) {
            $errors["date"] = "Invalid date";
        } else {
            $this->dateAsDateAsDatetime = date("Y-m-d H:i:s", $date);
        }

        $time = explode(":", $this->time);
        if (count($time) != 2 || (!is_numeric($time[0]) || !is_numeric($time[1]))) {

            $errors["time"] = "Invalid time format";

        } else {
            $hour = (int)$time[0];
            $minute = (int)$time[1];

            if (($hour < 0 || $minute < 0) || ($hour > 23 || $minute > 59)) {
                $errors["time"] = "Invalid time";

            } else {
                /* The input is valid, lets calculate it for db storage */

                $this->minutesFromMidnight = $minute + ($hour*60);

            }

        }

        if (trim($this->name) == "") {
            $errors["name"] = "The program must have a name";
        }

        return $errors;
    }


    /**
     * Returns an array with programs from the database
     */
    public function fetch() {

        $result = $this->database->fetchAll("SELECT `id`, `date`, `time`, `leadText`, `name`, `bLine`, `synopsis`, `url` FROM program ORDER BY `date` DESC;",array());

        /* Convert times */
        foreach($result as &$program) {
            $hour = (int)($program["time"]/60);
            $minute = (int)($program["time"] - ($hour*60));

            // pad with zeros i.e 01:05
            if ($hour < 10) $hour = "0$hour";
            if ($minute < 10) $minute = "0$minute";

            $program["time"] = "$hour:$minute";
        }

        return $result;
    }

}
