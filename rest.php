
<?php
include('Course.class.php');
/*Headers med inställningar för din REST webbtjänst*/

//Gör att webbtjänsten går att komma åt från alla domäner (asterisk * betyder alla)
header('Access-Control-Allow-Origin: *');
//Talar om att webbtjänsten skickar data i JSON-format
header('Content-Type: application/json');
//Vilka metoder som webbtjänsten accepterar, som standard tillåts bara GET.
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');
//Vilka headers som är tillåtna vid anrop från klient-sidan, kan bli problem med CORS (Cross-Origin Resource Sharing) utan denna.
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
//Läser in vilken metod som skickats och lagrar i en variabel
$method = $_SERVER['REQUEST_METHOD'];

//Om en parameter av id finns i urlen lagras det i en variabel
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}

$course = new Course();
switch($method) {
    case 'GET':
        if(isset($id)) { // koll om ett id har skickats med
            $response = array();
            $result = $course->getCourseById($id);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $response[] = $row;
                }
            }
        } else {
            $response = array(); 
            $result = $course->getCourse(); // hämta alla kurser
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $response[] = $row;
                }
            }
        }

        break;
    case 'POST':
        //Läser in JSON-data skickad med anropet och omvandlar till ett objekt.
        $data = json_decode(file_get_contents("php://input"), true);

        if($course->setCourse($data['courseName'], $data['courseCode'], $data['courseProgression'], $data['courseSyllabus'])) {
            $response = array("message" => 'kurs tillagd');
            http_response_code(201);
        } else {
            $response = array("message" => 'skicka med korrekt information');
            http_response_code(400);
        }
        break;
    case 'DELETE':
        if(!isset($id)) {
            http_response_code(400);
            $response = array("message" => "Skicka med ett korrekt id");  
        } else {
            if($course->deleteCourse($id)) {
                http_response_code(200);
            $response = array("message" => "Kurs raderad från databasen");
            }
        }
        break;
}
//Skickar svar tillbaka till avsändaren
echo json_encode($response);