<?php
class Model
{
    protected $connection;
    protected $database = 'dairy_farm';
    protected $server = 'localhost';
    protected $username = 'root';
    protected $password = 'root';

    function __construct()
    {
        mysqli_report(MYSQLI_REPORT_STRICT);
        try {
            $this->connection = mysqli_connect($this->server, $this->username, $this->password, $this->database);
        } catch (Exception $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    function verifyUser($email, $password)
    {
        $query = "select * from userinfo where email='$email' and pwd='$password'";
        try {
            $result = mysqli_query($this->connection, $query);
            if (mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_object($result);
                $response['Data'] = $user;
                $response['Code'] = true;
                $response['Message'] = "User authenticated!";
            } else {
                $response['Data'] = null;
                $response['Code'] = false;
                $response['Message'] = "Wrong email or password";
            }
            return $response;
        } catch (Exception $e) {
            echo "Database error: " . $e->getMessage();
        }
    }

    function addAnimal($id, $breed, $gender, $color, $dob, $price, $insemination, $insdate, $bullid, $pregnant, $startDate)
    {
        $query = "select * from animalinfo where id='$id'";
        $result = mysqli_query($this->connection, $query);
        $recordsFound = mysqli_num_rows($result);
        if ($recordsFound > 0) {
            $response['Code'] = 'invalid';
            $response['Message'] = "Animal id already exist!";
        } else {
            $query2 = "insert into animalinfo (id, breed, gender, color, dob, price, insemination, insdate, bullid, pregnant, startDate) values('$id', '$breed', '$gender', '$color', '$dob', '$price', '$insemination', '$insdate', '$bullid', '$pregnant', '$startDate')";
            if (mysqli_query($this->connection, $query2)) {
                $response['Code'] = 'success';
                $response['Message'] = "Animal added successfully!";

            } else {
                $response['Code'] = 'error';
                $response['Message'] = "Oops! Animal don't want to get in";

            }
        }
        return $response;
    }

    function allAnimals()
    {
        try {
            $animals = array();
            $query = "select * from animalinfo";
            $result = mysqli_query($this->connection, $query);
            $recordsFound = mysqli_num_rows($result);
            while ($row = mysqli_fetch_object($result)) {
                $animals[] = $row;
            }
            return $animals;
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function getBreeds()
    {
        try {
            $query = "select * from breeds";
            $result = mysqli_query($this->connection, $query);
            $breeds = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $breeds[] = $row['breedName'];
            }
            return $breeds;
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function addPregnant($cowid, $startdate)
    {
        try {
            $query = "insert into pregnantcows (cowid, startdate) values('$cowid', '$startdate')";
            mysqli_query($this->connection, $query);
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function getPregnantCows()
    {
        try {
            $query = "select * from pregnantcows";
            $data = array();
            $result = mysqli_query($this->connection, $query);
            while ($row = mysqli_fetch_object($result)) {
                $data[] = $row;
            }
            return $data;
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function addSeminationRecord($cowid, $type, $date, $bullid)
    {
        try {
            $query = "insert into insemination (cowid, type, date, bullid) values('$cowid', '$type', '$date', '$bullid')";
            mysqli_query($this->connection, $query);
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function getAnimalData($id)
    {
        try {
            $query = "select * from animalinfo where id='$id'";
            $result = mysqli_query($this->connection, $query);
            $data = mysqli_fetch_object($result);
            return $data;
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function getSeminationRecord($id)
    {
        try {
            $query = "select * from insemination where cowid='$id'";
            $result = mysqli_query($this->connection, $query);
            if (mysqli_num_rows($result) > 0) {
                $response['data'] = mysqli_fetch_object($result);
                $response['code'] = true;
                return $response;
            } else {
                $response['code'] = false;
                return $response;
            }
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function getPregnancyInfo($id)
    {
        try {
            $query = "select * from pregnantcows where cowid='$id'";
            $result = mysqli_query($this->connection, $query);
            if (mysqli_num_rows($result) > 0) {
                $response['data'] = mysqli_fetch_object($result);
                $response['code'] = true;
                return $response;
            } else {
                $response['code'] = false;
                return $response;
            }
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function getAllCows()
    {
        try {
            $query = "select id from animalinfo where gender='Cow'";
            $cows = array();
            $result = mysqli_query($this->connection, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                $cows[] = $row['id'];
            }
            return $cows;
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function addMilkRecord($id, $date, $amount, $times)
    {
        try {
            $query = "insert into milkrecords (cowid, date, milkamount, times) values('$id', '$date', '$amount', '$times')";
            mysqli_query($this->connection, $query);
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    // function totalMilkByDay()
    // {
    //     try {
    //         $query = "select milkamount, date from milkrecords where date = (select max(date) from milkrecords)";
    //         $result = mysqli_query($this->connection, $query);
    //         while ($row = mysqli_fetch_assoc($result))
    //         {
    //             $response['milk'] += $row['milkamount'];
    //             $response['date'] = $row['date'];
    //         }
    //         return $response;

    //     } catch (Exception $e) {
    //         echo "Database error : " . $e->getMessage();
    //     }
    // }

    function recordValid($date)
    {
        try {
            $query = "select times from milkrecords where date='$date'";
            $result = mysqli_query($this->connection, $query);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $times = $row['times'];
                return $times;
            } else {
                $times = 0;
                return $times;
            }


        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }

    }

    function updateMilkRecord($key, $date, $quantity, $count)
    {
        try {
            $query = "update milkrecords set milkamount = milkamount + $quantity, times = $count where cowid = '$key' and date = '$date'";
            $result = mysqli_query($this->connection, $query);

        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function addTotalMilk($date, $amount, $profit, $expense)
    {
        try {
            $query = "insert into milkperday (date, amount, saleprice, expense)
            values('$date', '$amount', '$profit', '$expense')";
            $result = mysqli_query($this->connection, $query);

        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function updateTotalMilk($date, $amount, $profit, $expense)
    {
        try {
            $query = "update milkperday set amount = amount + $amount,
             saleprice=saleprice+$profit, expense=expense+$expense where date = '$date'";
            $result = mysqli_query($this->connection, $query);

        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function getTotalMilkByDay($date, $data)
    {
        try {
            $query = "select $data from milkperday where date = '$date'";
            $result = mysqli_query($this->connection, $query);
            if ($row = mysqli_fetch_assoc($result)) {
                return $row[$data];
            } else
                return 0;
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function getWeeklyRecord($start, $end)
    {
        try {
            $query = "select * from milkperday where date between '$start' and '$end'";
            $result = mysqli_query($this->connection, $query);
            $records = array();
            while ($row = mysqli_fetch_array($result)) {
                $records[] = $row;
            }
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function addDailyExpense($expenseDate, $dailyExpense)
    {
        try {
            $query = "insert into expenseperday (expensedate, expenseamount) values('$expenseDate', '$dailyExpense')";
            mysqli_query($this->connection, $query);
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function getExpenseByDay($date)
    {
        try {
            $query = "select expenseamount from expenseperday where expensedate = '$date'";
            $result = mysqli_query($this->connection, $query);
            if ($row = mysqli_fetch_assoc($result)) {
                return $row['expenseamount'];
            } else
                return 0;
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function addTotalProfit($date, $amount)
    {
        try {
            $query = "insert into dailyprofit (date, profit) values('$date', '$amount')";
            $result = mysqli_query($this->connection, $query);

        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function updateProfit($date, $amount)
    {
        try {
            $query = "update dailyprofit set profit = profit + $amount where date = '$date'";
            $result = mysqli_query($this->connection, $query);

        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function updateAnimalInfo(
        $id,
        $breed,
        $color,
        $dob,
        $price,
        $insemination,
        $insdate,
        $bullid,
        $pregnant,
        $startDate,
        $abortiondate,
        $deliverydate
    ) {
        try {
            $query = "update animalinfo set breed='$breed', color='$color', 
            dob='$dob', price='$price', insemination='$insemination', insdate='$insdate', 
            bullid='$bullid', pregnant='$pregnant', startDate='$startDate', 
            abortiondate='$abortiondate', deliverydate='$deliverydate' where id='$id'";
            $result = mysqli_query($this->connection, $query);
            if ($result)
                return true;
            else
                return false;
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
            return false;
        }
    }


    function getProfitByDay($date)
    {
        try {
            $query = "select profit from dailyprofit where date = '$date'";
            $result = mysqli_query($this->connection, $query);
            if ($row = mysqli_fetch_assoc($result)) {
                return $row['profit'];
            } else
                return 0;
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function getCowRecordsByDuration($cowid, $start, $end)
    {
        try {
            $query = "select milkamount from milkrecords where cowid='$cowid' and date between '$start' and '$end'";
            $result = mysqli_query($this->connection, $query);
            $milkamount = array();
            if (mysqli_num_rows($result) > 0) {
                $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $response["data"] = $rows;
                $response["code"] = true;
                return $response;
            } else {
                $response["code"] = false;
                return $response;
            }
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function getGroupCows($start, $end, $min, $max)
    {
        try {
            $query = "SELECT cowid, AVG(milkamount) AS average
                      FROM milkrecords
                      WHERE date BETWEEN '$start' AND '$end'
                      GROUP BY cowid
                      HAVING average >= $min AND average < $max";

            $result = mysqli_query($this->connection, $query);
            if (mysqli_num_rows($result) > 0) {
                $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $response["data"] = $rows;
                $response["code"] = true;
                return $response;
            } else {
                $response["code"] = false;
                //$response["data"] = null;
                return $response;
            }
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function getGroupCounts($start, $end, $min, $max)
    {
        try {
            $query = "SELECT cowid, AVG(milkamount) AS average
                      FROM milkrecords
                      WHERE date BETWEEN '$start' AND '$end'
                      GROUP BY cowid
                      HAVING average >= $min AND average < $max";

            $result = mysqli_query($this->connection, $query);
            return mysqli_num_rows($result);
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function getBreedsAndCounts()
    {
        try {
            $query = "SELECT breed, COUNT(*) AS count FROM animalinfo GROUP BY breed";
            $result = mysqli_query($this->connection, $query);

            $breedsAndCounts = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $breed = $row['breed'];
                $count = $row['count'];
                $breedsAndCounts[$breed] = $count;
            }

            return $breedsAndCounts;
        } catch (Exception $e) {
            echo "Database error: " . $e->getMessage();
            return array();
        }
    }


    function addBreed($breed)
    {
        try {
            $checkQuery = "SELECT * FROM breeds WHERE breedName = '$breed'";
            $result = mysqli_query($this->connection, $checkQuery);

            if (mysqli_num_rows($result) > 0) {
                return false;
            } else {
                $query = "INSERT INTO breeds (breedName) VALUES ('$breed')";
                mysqli_query($this->connection, $query);
                return true;
            }
        } catch (Exception $e) {
            echo "Database error: " . $e->getMessage();
        }
    }

    function deleteBreed($breed)
    {
        try {
            $query = "delete from breeds where breedName='$breed'";
            $result = mysqli_query($this->connection, $query);
            if ($result)
                return true;
            else
                return false;
        } catch (Exception $e) {
            echo "Database error: " . $e->getMessage();
        }
    }

    function allMilkRecords()
    {
        try {
            $query = "select * from milkperday order by date desc";
            $result = mysqli_query($this->connection, $query);
            $records = array();
            if (mysqli_num_rows($result) > 0) {
                $records = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $response['code'] = true;
                $response['data'] = $records;
            } else
                $response['code'] = false;

            return $response;
        } catch (Exception $e) {
            echo "Database error: " . $e->getMessage();
        }
    }

    // function allExpenseRecords()
    // {
    //     try {
    //         $query = "select * from expenseperday order by expensedate desc";
    //         $result = mysqli_query($this->connection, $query);
    //         $records = array();
    //         if (mysqli_num_rows($result) > 0) {
    //             $records = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //             $response['code'] = true;
    //             $response['data'] = $records;
    //         } else
    //             $response['code'] = false;

    //         return $response;
    //     } catch (Exception $e) {
    //         echo "Database error: " . $e->getMessage();
    //     }
    // }

    function allProfitRecords()
    {
        try {
            $query = "select * from dailyprofit order by date desc";
            $result = mysqli_query($this->connection, $query);
            $records = array();
            if (mysqli_num_rows($result) > 0) {
                $records = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $response['code'] = true;
                $response['data'] = $records;
            } else
                $response['code'] = false;

            return $response;
        } catch (Exception $e) {
            echo "Database error: " . $e->getMessage();
        }
    }

    function cowRecordsPerDay()
    {
        try {
            $query = "select cowid, date, milkamount, times from milkrecords order by date desc";
            $result = mysqli_query($this->connection, $query);
            $records = array();
            if (mysqli_num_rows($result) > 0) {
                $records = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $response['code'] = true;
                $response['data'] = $records;
            } else
                $response['code'] = false;

            return $response;
        } catch (Exception $e) {
            echo "Database error: " . $e->getMessage();
        }
    }

    function getCowRecords($id)
    {
        try {
            $query = "select cowid, date, milkamount, times from milkrecords where cowid='$id' order by date desc";
            $result = mysqli_query($this->connection, $query);
            $records = array();
            if (mysqli_num_rows($result) > 0) {
                $records = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $response['code'] = true;
                $response['data'] = $records;
            } else
                $response['code'] = false;

            return $response;
        } catch (Exception $e) {
            echo "Database error: " . $e->getMessage();
        }
    }

    function searchAnimalTable($word)
    {
        $word = strtolower($word);
        $query = "SELECT * FROM animalinfo WHERE LOWER(id) = '$word' OR LOWER(breed) = '$word' OR LOWER(gender) = '$word'";
        $result = mysqli_query($this->connection, $query);
        if (mysqli_num_rows($result) > 0) {
            $response = array();
            while ($row = mysqli_fetch_assoc($result)) {
                if ($word === strtolower($row['id'])) {
                    $response['what'] = 'id';
                    $response['data'] = $row;
                    return $response;
                }

                if ($word === strtolower($row['breed'])) {
                    $response['what'] = 'breed';
                    $response['data'][] = $row;
                }

                if ($word === strtolower($row['gender'])) {
                    $response['what'] = 'gender';
                    $response['data'][] = $row;
                }
            }
            return $response;
        } else {
            $response['what'] = 'none';
            return $response;
        }
    }

    function getMonthlyData()
    {
        $currentYear = date('Y');

        $query = "SELECT MONTH(date) AS month, SUM(amount) AS total_milk, SUM(expense) AS total_expense, SUM(saleprice)-SUM(expense) AS total_profit
              FROM milkperday
              WHERE YEAR(date) = '$currentYear'
              GROUP BY MONTH(date)";

        $result = mysqli_query($this->connection, $query);

        $monthlyData = array();
        if (mysqli_num_rows($result) > 0)
        {
            $monthlyData = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        return $monthlyData;
    }

    function getMonthlyTotalMilk($month, $what)
    {
        $currentYear = date('Y');
        try {
            $query = "SELECT  SUM($what) AS data
              FROM milkperday
              WHERE YEAR(date) = '$currentYear' AND MONTH(date) = '$month'";

              $result = mysqli_query($this->connection, $query);
              if ($row = mysqli_fetch_assoc($result))
              {
                return $row['data'];
              }
              else return 0;
        } catch (Exception $e) {
            echo "Database error: " . $e->getMessage();
        }
    }

    function getSickAnimals()
    {
        try {
            $query = "select * from sick";
            $result = mysqli_query($this->connection, $query);
            if (mysqli_num_rows($result) > 0)
            {
                $response["data"] = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $response["code"] = true;
            } else {
                $response["code"] = false;
            }
            return $response;
        } catch (Exception $e) {
            echo "Database error: " . $e->getMessage();
        }
    }

    function deleteSick($id)
    {
        try {
            $query = "delete from sick where id='$id'";
            $result = mysqli_query($this->connection, $query);
            if ($result)
                return true;
            else
                return false;
        } catch (Exception $e) {
            echo "Database error: " . $e->getMessage();
        }
    }

    function addSick($id, $dis, $med, $temp, $date)
    {
        try {
            $checkQuery = "SELECT * FROM sick WHERE id = '$id'";
            $result = mysqli_query($this->connection, $checkQuery);

            if (mysqli_num_rows($result) > 0) 
            {
                $query = "update sick set disease='$dis', medications='$med', 
                            temperature='$temp', date='$date' 
                            where id='$id'";
                mysqli_query($this->connection, $query);
                return "updated";
            } 
            else 
            {
                $query = "insert into sick (id, disease, medications, temperature, date) 
                            values('$id', '$dis', '$med', '$temp', '$date')";
                mysqli_query($this->connection, $query);
                return "added";
            }
        } catch (Exception $e) {
            echo "Database error: " . $e->getMessage();
        }
    }

    function getSickCount()
    {
        try {
            $query = "select * from sick";
            $result = mysqli_query($this->connection, $query);
            if (mysqli_num_rows($result) > 0)
            {
                $size = mysqli_num_rows($result);
                return $size;
            } else {
                return 0;
            }
            
        } catch (Exception $e) {
            echo "Database error: " . $e->getMessage();
        }
    }

    function deleteAnimal($id)
    {
        try {
            $query = "delete from animalinfo where id='$id'";
            $result = mysqli_query($this->connection, $query);
            if ($result)
                return true;
            else
                return false;
        } catch (Exception $e) {
            echo "Database error: " . $e->getMessage();
        }
    }

    function deletePregnant($id)
    {
        try {
            $query = "delete from pregnantCows where cowid='$id'";
            $result = mysqli_query($this->connection, $query);
           
        } catch (Exception $e) {
            echo "Database error: " . $e->getMessage();
        }
    }

    function getWeeklyRecords($start, $end)
    {
        try {
            $query = "select cowid, SUM(milkamount) as milk
            from milkrecords 
            where date between '$start' and '$end'
            group by cowid";
            $result = mysqli_query($this->connection, $query);
            $records = array();
            while ($row = mysqli_fetch_array($result)) {
                $records[] = $row;
            }
            return $records;
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }


}
?>