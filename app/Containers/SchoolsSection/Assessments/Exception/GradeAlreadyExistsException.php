<?php

namespace App\Containers\SchoolsSection\Assessments\Exception;
use Exception;

class GradeAlreadyExistsException extends Exception
{
    protected $message = 'Student grade already exists for this subject and term.';
    protected $code = 409; // HTTP 409 Conflict
}
