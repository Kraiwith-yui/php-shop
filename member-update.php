<?php

session_start();
if (!isset($_SESSION['Member'])) {
    header('location: ./');
}
$member = $_SESSION['Member'];

include_once('functions/member-function.php');
$memberFn = new memberFunction();

if (isset($_POST['submit'])) {
    print_r($_POST);
    $fullname = $_POST['fullname'];
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $age = $_POST['age'];
    $idcard = $_POST['idcard'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $result = $memberFn->memberUpdate($member['Member_id'], $fullname, $gender, $age, $idcard, $address, $phone, $email);
    if ($result) {
        $newMember = $memberFn->memberGetById($member['Member_id'])->fetch_assoc();
        $_SESSION['Member'] = $newMember;
        
        echo "<script>window.location.href='member-detail.php';</script>";
    } else {
        echo "<script>window.alert('Failed to Update!');</script>";
        echo "<script>window.location.href='member-detail.php';</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Namploy Shop</title>
    <link rel="icon" href="./assets/logo.ico" type="image/ico">

    <?php include_once('./assets/styles.html'); ?>
</head>

<body>
    <?php include_once('./components/navbar.php'); ?>

    <div class="container pt-3 pb-5">
        <h2> <i class="fas fa-user-circle"></i> แก้ไขข้อมูล </h2>
        <div class="card">
            <div class="card-body">
                <div class="container-fluid">
                    <form method="POST">
                        <div class="row">
                            <!-- LEFT -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="fname" class="text-muted"> ชื่อ-สกุล </label>
                                    <input type="text" id="fname" name="fullname" class="form-control" value="<?php echo $member['Member_fullname']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="idcard" class="text-muted"> เลขประจำตัวประชาชน </label>
                                    <input type="text" id="idcard" name="idcard" class="form-control" value="<?php echo $member['Member_idcard']; ?>" maxlength="13">
                                </div>
                                <div class="form-group">
                                    <label for="email" class="text-muted"> อีเมล </label>
                                    <input type="email" id="email" name="email" class="form-control" value="<?php echo $member['Member_email']; ?>" required>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="" class="text-muted"> เพศ </label>
                                            <div class="">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="radio1" name="gender" class="custom-control-input" value="ชาย" <?php echo $member['Member_gender'] == 'ชาย' ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label" for="radio1">ชาย</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="radio2" name="gender" class="custom-control-input" value="หญิง" <?php echo $member['Member_gender'] == 'หญิง' ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label" for="radio2">หญิง</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="age" class="text-muted"> อายุ </label>
                                            <input type="number" id="age" name="age" class="form-control" value="<?php echo $member['Member_age']; ?>" min="0" max="99">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- RIGHT -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="phone" class="text-muted"> เบอร์โทร </label>
                                    <input type="text" id="phone" name="phone" class="form-control" value="<?php echo $member['Member_phone']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="address" class="text-muted"> ที่อยู่ </label>
                                    <textarea name="address" id="address" rows="3" class="form-control"><?php echo $member['Member_address']; ?></textarea>
                                </div>

                                <div class="" style="position: absolute; bottom: 0; right: 0;">
                                    <button type="submit" name="submit" class="btn btn-info"> <i class="fas fa-save"></i> บันทึกข้อมูล </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>

    <?php include_once('./assets/scripts.html'); ?>
</body>

</html>