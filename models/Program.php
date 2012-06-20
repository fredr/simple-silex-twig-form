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

}
