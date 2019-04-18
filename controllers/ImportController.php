<?php


namespace App\Controllers;

use App\Components\Session;
use App\Models\User;
use App\Transformers\UserTransformer;

class ImportController extends BaseController
{
    public function import()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $_FILES;
            if (empty($data) || !isset($data['file']) || $data['file']['error']) {
                Session::setFlash('error', [['Error: import a file!']]);
                header('Location: http://'.$_SERVER['HTTP_HOST']. "/");
            } else {
                $file = $data['file'];
                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                if (!preg_match("~^[c|C]{1}[s|S]{1}[v|V]{1}$~", $extension)) {
                    Session::setFlash('error', [['Error: import a file of .csv extension!!']]);
                    header('Location: http://'.$_SERVER['HTTP_HOST']. "/");
                } else {
                    if ((int)$file['size'] > 1024000) {
                        Session::setFlash('error', [['Error: file should be less then 1MB']]);
                        header('Location: http://'.$_SERVER['HTTP_HOST']. "/");
                    } else {
                        $fileData = $this->parseCsvFile($file['tmp_name']);
                        if (empty($fileData)) {
                            Session::setFlash('error', [['Error: file has no data']]);
                            header('Location: http://'.$_SERVER['HTTP_HOST']. "/");
                        } else {
                            $transformer = new UserTransformer($fileData);
                            $transformedData = $transformer->getData();
                            foreach ($transformedData as $userData) {
                                $user = User::find($userData['UID']);
                                if (!$user) {
                                    $user = new User();
                                    $user->id = $userData['UID'];
                                    $user->name = $userData['Name'];
                                    $user->age = $userData['Age'];
                                    $user->email = $userData['Email'];
                                    $user->phone = $userData['Phone'];
                                    $user->gender = $userData['Gender'];
                                    $result = $user->save();
                                } else {
                                    $user->name = $userData['Name'];
                                    $user->age = $userData['Age'];
                                    $user->email = $userData['Email'];
                                    $user->phone = $userData['Phone'];
                                    $user->gender = $userData['Gender'];
                                    $result = $user->update();
                                }
                            }
                            if ($result) {
                                Session::setFlash('success', [['Data was successfully saved']]);
                                header('Location: http://'.$_SERVER['HTTP_HOST']. "/");
                            } else {
                                Session::setFlash('error', [['Error: data was not saved. Please, attempt later']]);
                                header('Location: http://'.$_SERVER['HTTP_HOST']. "/");
                            }
                        }
                    }
                }
            }
        } else {
            throw new \Exception("Error: method - " . $_SERVER['REQUEST_METHOD'] . ' is not allowed');
        }
    }

    protected function parseCsvFile($path)
    {
        $content = trim(file_get_contents($path));
        if (!strpos($content, "\r\n")) {
            $row_delimiter = "\n";
        } else {
            $row_delimiter = "\r\n";
        }
        $lines = explode($row_delimiter, $content);

        $data = [];
        $errors = [];
        foreach( $lines as $key => $line ){
            $lineArray = str_getcsv( $line, "," );
            if (count($lineArray) !== 6) {
                $errors[] = 'Error, csv file is wrong!';
                break;
            }
            if ($key === 0) {
                foreach ($lineArray as $i => $field) {
                    switch ($i) {
                        case 0:
                            if ($field != "UID") {
                                $errors[] = 'Error, csv file is wrong!';
                                break 2;
                            }
                            break;
                        case 1:
                            if ($field != "Name") {
                                $errors[] = 'Error, csv file is wrong!';
                                break 2;
                            }
                            break;
                        case 2:
                            if ($field != "Age") {
                                $errors[] = 'Error, csv file is wrong!';
                                break 2;
                            }
                            break;
                        case 3:
                            if ($field != "Email") {
                                $errors[] = 'Error, csv file is wrong!';
                                break 2;
                            }
                            break;
                        case 4:
                            if ($field != "Phone") {
                                $errors[] = 'Error, csv file is wrong!';
                                break 2;
                            }
                            break;
                        case 5:
                            if ($field != "Gender") {
                                $errors[] = 'Error, csv file is wrong!';
                                break 2;
                            }
                            break;
                    }
                }
            }
            $data[] = $lineArray;
        }

        if (!empty($errors)) {
            Session::setFlash('error', [$errors]);
            header('Location: http://'.$_SERVER['HTTP_HOST']. "/");
            die;
        }
        return $data;
    }
}