<?php
class sqlBot
{
    public function __construct($conn, $sql)
    {
        $this->conn = $conn;
        $this->sql = $sql;
    }

    function tryConnection()
    {
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    //returns the status of the table if it is empty
    function tableStatus($result)
    {
        if ($result->num_rows < 1) {
            echo "<br><br><h3 class='alert'>" . $this->resultStatus . "</h3>";
        }
    }

    function tableHeadersAdmin()
    {
        echo "<table class='admin'><tr>
        <th>Room</th>
        <th>Delete Room</th>
        </tr>";
    }

    function adminView()
    {
        $result = $this->conn->query($this->sql);
        if ($result->num_rows >= 1) {
            //columns
            $this->tableHeadersAdmin();

            while ($row = $result->fetch_assoc()) {

                echo "<tr>
              <td>" . $row["Room"] . "</td>
              <td><form method='post'><button  type='submit' OnClick=\"return confirm('Are you sure you want to delete this room?');\" name=delete" . $row["Room"] . " class= 'delete'>Delete</button></form></td>
              </tr>";
            }
        } else {
            $this->tableHeadersAdmin();
            $this->resultStatus = 'No Rooms Added';
        }
        echo "</table>";

        $this->tableStatus($result);
    }

    function tableHeadersDentist()
    {
        echo "<table class='dentist'><tr>
        <th>Room</th>
        <th>Status</th>
        <th>Time Waiting</th>

        <th>Clear Time</th>
        </tr>";
    }

    //get results for user view
    function dentistView()
    {
        $result = $this->conn->query($this->sql);
        if ($result->num_rows >= 1) {
            $this->tableHeadersDentist();
            while ($row = $result->fetch_assoc()) {

                echo "<tr>
                  <td>" . $row["Room"] . "</td>
                  <td>" . $row["Status"] . "</td>
                  <td id='startTime" . $row["Room"] . "'>" . $row["ReadyTime"] . "</td>
                  <td><form method='post'><button type='submit' name=clear" . $row["Room"] . " class= 'clear'>Clear</button></form></td>
                  </tr>";
            }
        } else {
            $this->tableHeadersUser();
            $this->resultStatus = 'No Rooms Added';
        }

        echo "</table>";

        $this->tableStatus($result);
    }


    function tableHeadersUser()
    {
        echo "<table class='user'><tr>
        <th>Room</th>
        <th>Status</th>
        <th>Time Waiting</th>
        <th>Notify</th>
        <th>Clear Time</th>
        </tr>";
    }

    //get results for user view
    function userView()
    {
        $result = $this->conn->query($this->sql);
        if ($result->num_rows >= 1) {
            $this->tableHeadersUser();
            while ($row = $result->fetch_assoc()) {

                echo "<tr>
                  <td>" . $row["Room"] . "</td>
                  <td>" . $row["Status"] . "</td>
                  <td id='startTime" . $row["Room"] . "'>" . $row["ReadyTime"] . "</td>
                  <td><form method='post'><button type='submit' OnClick=\"return confirm('Are you sure? This action will send a notification to the dentist.');\" name=waiting" . $row["Room"] . " class = 'notify'>Notify Dentist</button></form></td>
                  <td><form method='post'><button type='submit' name=clear" . $row["Room"] . " class= 'clear'>Clear</button></form></td>
                  </tr>";
            }
        } else {
            $this->tableHeadersUser();
            $this->resultStatus = 'No Rooms Added';
        }

        echo "</table>";

        $this->tableStatus($result);
    }
}
