<?php
class Course {
    public $id;
    public $name;
    public $code;
    public $progression;
    public $syllabus;
    private $conn;
    public function __construct() {
        $this->conn = new mysqli('localhost', 'root', 'lpslps', 'rest');
        // $this->conn = new mysqli('studentmysql.miun.se', 'maaf2200', 'm3WM!VLkq7', 'maaf2200');
    }
    function getCourse() { //Hämta kurser från databasen
        $sql = 'SELECT * from course';
        $result = $this->conn->query($sql);
        return $result;
    }
    function setCourse($courseName, $courseCode, $courseProgression, $courseSyllabus) { // lägg in data i databasen
        $sql = "INSERT INTO course (courseName, courseCode, courseProgression, courseSyllabus) values ('$courseName', '$courseCode', '$courseProgression', '$courseSyllabus')";
        $this->conn->query($sql);
    }
    function getCourseById($id) { //hämta kurs med specifikt id
        $sql = "SELECT * from course WHERE id=$id";
        $result = $this->conn->query($sql);
        return $result;
    }
    function setCourseById($id, $courseName, $courseCode, $courseProgression, $courseSyllabus) {
        $sql = "UPDATE course SET courseName = '$courseName', courseCode = '$courseCode', courseProgression = '$courseProgression', courseSyllabus = '$courseSyllabus' WHERE id = $id";
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }
    function deleteCourse($id) { // Ta bort vald kurs från databasen
        $sql = "DELETE FROM course WHERE id=$id";
        if($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }
}