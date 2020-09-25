<?php
include 'config.php';
class buttonChecker
{
    public $rooms = array();
    public $resultStatus = "";
    public function __construct($conn, $text, $sql)
    {
        $this->conn = $conn;
        $this->send = $text;
        $this->sql = $sql;
    }
    

    function getRoomList()
    {
        $result = $this->conn->query($this->sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($this->rooms, $row["Room"]);
            }
        }
    }


    function checkNotify()
    {
        //if notify dentist is pressed
        foreach ($this->rooms as $i) {
            if (isset($_POST['waiting' . $i])) {
                //Update ReadyTime to time of button press (UTC - 6 hours for Mountain Time)
                $sql2 = "UPDATE Main SET Status='Waiting', ReadyTime=TIME_FORMAT(DATE_ADD(LOCALTIME(), INTERVAL $GLOBALS[timeChange] HOUR), '%T') WHERE Room='" . $i . "'";
                $this->conn->query($sql2);
                $body = 'Room ' . $i . ' is ready!';
                $text = $this->send;
                $text($body);
            }
        }
    }

    function checkClear()
    {
        //if clear is pressed
        foreach ($this->rooms as $i) {
            if (isset($_POST['clear' . $i])) {
                //Update ReadyTime to time of button press (UTC - 6 hours for Mountain Time)
                $sql3 = "UPDATE Main SET Status='Okay', ReadyTime='N/A' WHERE Room='" . $i . "'";
                //update record
                $this->conn->query($sql3);
            }
        }
    }

    function checkDelete()
    {
        foreach ($this->rooms as $i) {
            if (isset($_POST['delete' . $i])) {
                //Update ReadyTime to time of button press (UTC - 6 hours for Mountain Time)
                $sql4 = "DELETE FROM Main  WHERE Room='" . $i . "'";
                //update record
                $this->conn->query($sql4);
            }
        }
    }

    function checkAdd()
    {
        if (isset($_POST["roomName"])) {
            $newRoom = $_POST["roomName"];
            $t = 0;
            foreach ($this->rooms as $i) {
                if ($newRoom == $i) {
                    $t = 1;
                }
            }

            if ($t == 0) {
                if (preg_match('/\s/', $newRoom)) {
                    $error = 'ERROR: Room name cannot contain spaces.';
                } else if (strlen(trim($newRoom)) == 0) {
                    $error = 'ERROR: Room name cannot be blank.';
                } else {

                    $addRoom = "INSERT INTO Main VALUES ('" . $newRoom . "', 'Okay', 'N/A')";
                    $this->conn->query($addRoom);
                }
            } else {
                $error = 'ERROR: Room already exists!';
            }
        }
        if (isset($error)) {
            alert($error);
        }
    }
}
