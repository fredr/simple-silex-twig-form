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
    public function Index() {
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

        // show the form again if there where errors (and show what the errors where)
        if (count($errors) > 0) {
            return $this->app['twig']->render('index.html.twig', array("errors" => $errors, "program" => $program));
        }

        // store the record in db
        $program->persist();

        return $this->app->redirect('/programs.html');
    }

    /**
     * Deletes the record and redirects to the list
     * @return view
     */
    public function DeleteProgram($id) {

        $program = new Program($this->app["db"]);

        // load the program and delete it
        $program->load($id);
        $program->remove();

        return $this->app->redirect('/programs.html');
    }

    public function Programs($format, $page, $size) {

        // make sure we have a valid format
        if ($format != "html" && $format != "xml") {
            $format = "html";
        }

        // make sure we have valid page and size
        if (!is_numeric($page)) $page = 1;
        if (!is_numeric($size)) $size = 10;
        if ($page < 1) $page = 1;
        if ($size < 1) $size = 1;

        $program = new Program($this->app["db"]);
        $data = $program->fetch($page, $size);

        $programs = $data["programs"];
        $paging = $data["paging"];


        // set paging URLs
        if ($paging["next"] != null) {
            $paging["next"] = "/programs.$format/{$paging["next"]}/$size";
        }
        if ($paging["prev"] != null) {
            $paging["prev"] = "/programs.$format/{$paging["prev"]}/$size";
        }



        return $this->app['twig']->render("programs.$format.twig", array("programs" => $programs, "paging" => $paging));

    }
}
