<?php
/**
 * Author: Fredrik Enestad @ Devloop AB (fredrik@devloop.se)
 * Date: 2012-06-20
 * Time: 08:23
 */

require_once __DIR__."/ControllerBase.php";
require_once __DIR__."/../models/Program.php";

class ProgramController extends ControllerBase
{
    /**
     * Renders the input form
     * @return view
     */
    public function Programs() {
        return $this->app['twig']->render('index.html.twig', array("errors" => array(), "program" => array()));
    }

    /**
     * Adds a new record and redirects to the list if ok, or back to form if the data was not correct
     * @return view
     */
    public function AddProgram() {
        $data = $this->app["request"];

        $program = new Program($this->app["db"]);

        $program->date          = $data->get("date");
        $program->time          = $data->get("time");
        $program->leadText      = $data->get("leadText");
        $program->name          = $data->get("name");
        $program->bLine         = $data->get("b-line");
        $program->synopsis      = $data->get("synopsis");
        $program->url           = $data->get("url");

        // check for errors
        $errors = $program->validate();

        if (count($errors) > 0) {
            return $this->app['twig']->render('index.html.twig', array("errors" => $errors, "program" => $program));
        }

        // store the record in db
        $program->persist();

        return $this->app->redirect('/programs');

    }
}
