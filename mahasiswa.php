<?php
include 'connection.php';

function get_all()
{
    global $conn;

    $per_page= 10;
    $page = 1;
    $sort = 'id:asc';
    $sorted = ['id','asc'];
    $where = [];
    $search = null;
    $search_coloumn = ['nim','nama','nik','alamat'];

    if (isset($_GET['count'])) {
        $count = true;
    }
    if (isset($_GET['per_page'])){
        $per_page = $_GET['per_page'];
    }
    if (isset($_GET['page'])){
        $page = $_GET['page'];
    }
    if (isset($_GET['sort'])) {
        $sort = $_GET['sort'];
        $sorted = explode(":", $sort);
    }
    if (isset($_GET['where'])) {
        $where = json_decode(html_entity_decode($_GET['where']),true);
    }
    if (isset($_GET['search'])) {
        $search =$_GET['search'];
    }
    
    #default response
    $response = [];
    $response['success'] = false;
    $response['message'] = 'Get Data Failed';
    $response['data'] = [];

    # start query
    $sql = "SELECT * from mahasiswa ";
    $sql .= " where 1=1 ";

    if ($where)
    {
        $i =0;
        $sql .= " and ";
        foreach ($where as $key => $value) {
            $sql .= " $key = '$value' ";
            $i += 1;
            if ($i < count($where)) {
                $sql .= " and ";
            }
        }
    }
    if ($search)
    {
        $i =0;
        $sql .= " and ";
        foreach ($search_coloumn as $column) {
            $sql .= " $column like '%$search%' ";
            $i += 1;
            if ($i < count($search_coloumn)){
                $sql .= " or ";
            }
        }
    }
    $sql .= " order by " . $sorted[0] . " " . $sorted[1];
    $sql .= " limit $per_page";
    $sql .= " offset " . ($page-1) * $per_page;

    #echo $sql;
    $result = $conn->query($sql);

    if ($result)
    {
    $data = [];
    while ($row = $result->fetch_assoc()) {
            $temp = $row;
            $temp['id'] = (int)$row['id'];
            $temp['is_active'] = (int)$row['is_active'];
            $tanggal_lahir_lama = new DateTime($temp['tanggal_lahir']);
            $tanggal_lahir_baru = $tanggal_lahir_lama->format('d F Y');
            $temp['tanggal_lahir'] = $tanggal_lahir_baru;
            array_push($data, $temp);
    }
    
            $response['success'] = true;
            $response['message'] = 'Get Data Success';
            $response['data'] = [];
        }
        else
        {
            $response['success'] = false;
            $response['message'] = 'Internal server error. ' . mysqli_error($conn);
            $response['data'] = [];
        }
        return $response;
}
function get_count(){
    global $conn;
    $per_page = 10;
    $page = 1;
    $sort = 'id:asc';
    $sorted = ['id','asc'];
    $where = [];
    $search = null;
    $search_column = ['nim','nama','nik','alamat'];

    if (isset($_GET['per_page'])) {
        $per_page = $_GET['per_page'];
    }
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    }
    if (isset($_GET['sort'])) {
        $sort = $_GET['sort'];
        $sorted = explode(":", $sort);
    }
    if (isset($_GET['where'])) {
        $where = json_decode(html_entity_decode($_GET['where']), true);
    }
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
    }

    #dwfault response
    $response = [];
    $response['success'] = false;
    $response['message'] = 'Get Data Failed';
    $response['data'] = [];

    #start QUery
    $sql = "SELECT * from mahasiswa ";
    $sql .= " where 1=1 ";

    if ($where) {
        $i = 0;
        $sql .= " and ";
        foreach ($where as $key => $value) {
            $sql .= " $key = '$value' ";
            $i +=1;
            if ($i < count($where)) {
                $sql .= " and ";
            }
        }
    }

    if ($search) {
        $i=0; 
        $sql .= " and ";
        foreach ($search_column as $column) {
        $sql .= " $column like '%$search%' ";
        $i += 1;
        if ($i < count($search_column)) {
            $sql .= " or ";
        }
    }
}

$sql .= " order by" . $sorted[0] . " " . $sorted[1];
$sql .= " limit $per_page";
$sql .= " offset" . ($page-1) * $per_page;

$result = $conn->query($sql);
if ($result)
{
    $response['success'] = true;
    $response['message'] = 'Get Data Success';
    $response['data'] = [];
    $response['data'] ['count'] = $result->num_rows;
}
else
{
    $response['success'] = false;
    $response['message'] = 'Internal server error. ' . mysqli_error($conn);
    $response['data'] = [];
}
 return $response;

}
function get_detail($id){
    global $conn;
    $sql = "SELECT * from mahasiswa where id = $id";

    #echo $sql;
    $result = $conn->query($sql);

    $data = [];
    while($row = $result->fetch_assoc()) {
        $temp = $row;
        $temp['id'] = (int)$row['id'];
        $temp['is_active'] = (int)$row['is_active'];
        $tanggal_lahir_lama = new DateTime($temp['tanggal_lahir']);
        $tanggal_lahir_baru = $tanggal_lahir_lama-> format ('d F Y');
        $temp['tanggal_lahir'] = $tanggal_lahir_baru;
        array_push($data, $temp);
    }
    if (count($data) > 0)
    {
        $data = $data[0];

        $response['success'] = true;
        $response['message'] = 'Get data success';
        $response['data'] = $data;
    }
    else{
        $response['success'] = true;
        $response['message'] = "data not found";
        $response['data'] = [];
    }
    return $response;
}
function insert(){
    global $conn;
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

$nim = '';
$nama = '';
$nik = '';
$tanggal_lahir = '';
$jenis_kelamin = '';
$alamat = '';
$is_active = '1';

if (isset($data['nim'])) {
    $nim = $data['nim'];
}
if (isset($data['nik'])) {
    $nik = $data['nik'];
}
if (isset($data['nama'])) {
    $nama = $data['nama'];
}
if (isset($data['tanggal_lahir'])) {
    $tanggal_lahir = $data['tanggal_lahir'];
}
if (isset($data['jenis_kelamin'])) {
    $jenis_kelamin = $data['jenis_kelamin'];
}
if (isset($data['alamat'])) {
    $alamat = $data['alamat'];
}
if (isset($data['is_active'])) {
    $is_active = $data['is_active'];
}

$response  = [];
$response['success'] = false;
$response['message'] = "Insert data failed!";
$response['data'] = [];

if ($nim != "" and $nama != "") {
    $sql = "INSERT INTO mahasiswa(nim, nik, nama, tanggal_lahir, jenis_kelamin, alamat, is_active) 
    VALUES ('$nim','$nik','$nama','$tanggal_lahir','$jenis_kelamin','$alamat','$is_active')";

    $result = $conn->query($sql);
    if ($result) {

        $last_id = $conn->insert_id;
        $sql_get = "SELECT * FROM mahasiswa where id = '$last_id'";
        $result_get = $conn->query($sql_get);

        $data_get = [];
        while ($row = $result_get->fetch_assoc()) {
                $temp = $row;
                $temp['id'] = (int)$row['id'];
                $temp['is_active'] = (int)$row['is_active'];
                $tanggal_lahir_lama = new DateTime($temp['tanggal_lahir']);
                $tanggal_lahir_baru = $tanggal_lahir_lama->format('d F Y');
                $temp['tanggal_lahir'] = $tanggal_lahir_baru;
                array_push($data_get, $temp);
        }

        $data_get = $data_get[0];

        $response['success'] = true;
        $response['message'] = "Insert data successfully!";
        $response['data'] = $data_get;
    } else 
    {
        $response['success'] = false;
        $response['message'] = 'Internal server error. ' . mysqli_error($conn);
        $response['data'] = [];
    }
}
else
{
        $response['success'] = false;
        $response['message'] = 'Tidak ada data yang dikirim.';
        $response['data'] = [];
}
 return $response;
}
function update($id){
    global $conn;
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

$nim = '';
$nama = '';
$nik = '';
$tanggal_lahir = '';
$jenis_kelamin = '';
$alamat = '';
$is_active = '1';

if (isset($data['nim'])) {
    $nim = $data['nim'];
}
if (isset($data['nik'])) {
    $nik = $data['nik'];
}
if (isset($data['nama'])) {
    $nama = $data['nama'];
}
if (isset($data['tanggal_lahir'])) {
    $tanggal_lahir = $data['tanggal_lahir'];
}
if (isset($data['jenis_kelamin'])) {
    $jenis_kelamin = $data['jenis_kelamin'];
}
if (isset($data['alamat'])) {
    $alamat = $data['alamat'];
}
if (isset($data['is_active'])) {
    $is_active = $data['is_active'];
}

if ($nim != "" and $nama != "") {
    $sql = "UPDATE mahasiswa SET
    nim='$nim', nik='$nik', nama='$nama', tanggal_lahir='$tanggal_lahir',
    jenis_kelamin='$jenis_kelamin', alamat='$alamat', is_active='$is_active'
    WHERE id=$id";

    $result = $conn->query($sql);
    if ($result)
    {
        $sql_get = "SELECT * FROM mahasiswa where id = $id";
        $result_get = $conn->query($sql_get);

        $data_get = [];
        while ($row = $result_get->fetch_assoc()) {
                $temp = $row;
                $temp['id'] = (int)$row['id'];
                $temp['is_active'] = (int)$row['is_active'];
                $tanggal_lahir_lama = new DateTime($temp['tanggal_lahir']);
                $tanggal_lahir_baru = $tanggal_lahir_lama->format('d F Y');
                $temp['tanggal_lahir'] = $tanggal_lahir_baru;
                array_push($data_get, $temp);
        }

        $data_get = $data_get[0];

        $response['success'] = true;
        $response['message'] = "Update Data Success";
        $response['data'] = $data_get;
    } 
    else 
    {
        $response['success'] = false;
        $response['message'] = 'Internal server error. ' . mysqli_error($conn);
        $response['data'] = [];
    }
}
else
{
        $response['success'] = false;
        $response['message'] = 'Tidak ada data yang dikirim.';
        $response['data'] = [];
}
    return $response;
}
function delete($id){
    global $conn;
    $sql_get="SELECT * from mahasiswa where id = $id";
        $result_get = $conn->query($sql_get);
        if($result_get->num_rows > 0){
            $sql_delete = "DELETE from mahasiswa where id = $id";
            $result_delete =  $conn->query($sql_delete);

            $response['success'] = true;
            $response['message'] = 'delete Data Success';
            $response['data'] = [];
        }else{
            $response['success'] = false;
            $response['message'] = 'Data Not Found';
            $response['data'] = [];
        }
    return $response;
}

#get method 
$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));

#get params id
$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_segments = explode('/', $uri_path);

#default response
$response  = [];
$response['success'] = false;
$response['message'] = "Failed!";
$response['data'] = [];

switch ($method) {
    case 'GET':
        if (isset($uri_segments[3]) and $uri_segments[3] != null)
        {
            $response = get_detail($uri_segments[3]);
        }
        else
        {
            if (isset($_GET['count']))
            {
                $response = get_count();
            }
            else{
                $response = get_all();
            }
        }
        break;

        case 'POST';
            $response = insert();
            break;
        
        case 'PUT';
            if (isset($uri_segments[3]) and $uri_segments[3] != null)
            {
                $response = update($uri_segments[3]);
            }
            else 
            {
                $response['message'] = 'Parameter Data Not Found';
            }
            break;

        case 'DELETE';
        if (isset($uri_segments[3]) and $uri_segments[3] != null)
        {
            $response = delete($uri_segments[3]);
        }
        else 
        {
            $response['message'] = 'Parameter Data Not Found';
        }
        break;
        default:
            $response['message'] = 'Method tidak dikenal.';
            break;
}

# close mysql connection
$conn->close();
#response code
if ($response['success'] == true) {
    header("HTTP/1.1.200");
} else {
    header("HTTP/1.1.500");
}

#response data to json
header('Content-Type: application/json');
echo json_encode($response);
?>