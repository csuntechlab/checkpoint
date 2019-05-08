<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\ProgramContract;

class ProgramController extends Controller
{
    private $programUtility;
    public function __construct(ProgramContract $programContract)
    {
        $this->programUtility = $programContract;
    }


    public function create(Request $request)
    {
        dd("Create");
    }

    public function all(Request $request)
    {
        dd("All");
    }

    public function update(Request $request)
    {
        dd("update");
    }

    public function delete(Request $request)
    {
        dd("delete");
    }
}
