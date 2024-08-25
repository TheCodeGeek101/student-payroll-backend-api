<?php


namespace App\Containers\SchoolsSection\Grades\Exceptions;

use Exception;

class FinalGradeAlreadyExistsException extends Exception
{
    protected $message = 'The final grade for this student in this subject and term already exists.';
    protected $code = 409; // HTTP 409 Conflict
}
