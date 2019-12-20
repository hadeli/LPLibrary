<?php


namespace Alexandrie\Controller;


use Symfony\Component\HttpFoundation\Request;


interface ObjectController {

    public  function displayAll();
    public  function display(int $id);
    public  function delete(int $id);
    public  function update(Request $request, int $id);
    public  function add(Request $request);

}