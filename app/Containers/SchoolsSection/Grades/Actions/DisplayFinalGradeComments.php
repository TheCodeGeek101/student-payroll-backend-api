<?php

namespace App\Containers\SchoolsSection\Grades\Actions;

use App\Ship\Actions\Action;

class DisplayFinalGradeComments extends Action
{
    public function run(string $letterGrade): string
    {
        switch ($letterGrade) {
            case 'A':
                return 'Excellent work! Keep up the great performance.';
            case 'B':
                return 'Good job! You have a solid understanding of the material.';
            case 'C':
                return 'Fair performance. You need to work on improving your understanding.';
            case 'D':
                return 'Below average. Significant improvement is needed.';
            case 'F':
                return 'Fail. You need to put in more effort and seek help if needed.';
            default:
                return 'No comments available.';
        }
    }
}
