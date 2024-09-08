<?php

namespace App\Containers\SchoolsSection\Grades\Actions;

use App\Ship\Actions\SubAction;

class MapPointsToLetterAction extends SubAction
{
    /**
     * Map the grade value (percentage) to an IGCSE letter grade.
     *
     * @param float $gradeValue
     * @return string
     */
    public function run(float $gradeValue, $classId): string
    {
        if ($classId === 1 || $classId === 2) {
            if ($gradeValue >= 80) {
                return 'A';
            } else if ($gradeValue >= 70) {
                return 'B';
            } else if ($gradeValue >= 60) {
                return 'C';
            } else if ($gradeValue >= 50) {
                return 'D';
            } else if ($gradeValue >= 40) {
                return 'F';
            } else if ($gradeValue >= 30) {
                return 'F';
            } else {
                return 'F'; // Ungraded
            }
        } else if ($classId === 3 || $classId === 4) {
            if ($gradeValue >= 80) {
                return '1';
            } else if ($gradeValue >= 70) {
                return '2';
            } else if ($gradeValue >= 60) {
                return '3';
            } else if ($gradeValue >= 50) {
                return '4';
            } else if ($gradeValue >= 40) {
                return '5';
            } else if ($gradeValue >= 30) {
                return '6';
            } else {
                return '7'; // Ungraded
            }
        }
    }
}
