<?php
session_start();
if (!isset($_SESSION['filename'])) {
    $_SESSION['filename'] = '';
}

if (isset($_POST['filename'])) {
    $_SESSION['filename'] = $_POST['filename'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>File Handling</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
</head>

<body>
    <h2>File Handling</h2>

    <form method="GET">
        <br>

        <label>Choose Operation :</label>
        <div>
            <table>
                <tr>
                    <td><button type="submit" name="operation" value="read" class="btn">Read File</button></td>
                    <td><button type="submit" name="operation" value="write" class="btn">Write to File</button></td>
                    <td><button type="submit" name="operation" value="append" class="btn">Append to File</button></td>
                </tr>
                <tr>
                    <td><button type="submit" name="operation" value="copy" class="btn">Copy File</button></td>
                    <td><button type="submit" name="operation" value="delete" class="btn">Delete File</button></td>
                    <td><button type="submit" name="operation" value="rename" class="btn">Rename File</button></td>
                </tr>
                <tr>
                    <td><button type="submit" name="operation" value="create" class="btn">Create File</button></td>
                    <td><button type="submit" name="operation" value="type" class="btn">Get File Type</button></td>
                    <td><button type="submit" name="operation" value="stats" class="btn">Get File Stats</button></td>
                </tr>
                <tr>
                    <td colspan="3"><button type="submit" name="operation" value="permissions" class="btn">Check
                            Permissions</button></td>
                </tr>

            </table>
        </div>
    </form>
    <div>
        <form method="POST">
            <div>
                <label for="filename">Enter File Name:</label>
                <input type="text" id="filename" name="filename" value="<?php echo $_SESSION['filename']; ?>">
            </div>
            <label for="operation">Operation : <?php echo isset($_GET['operation']) ? $_GET['operation'] : ''; ?></label>
            <input hidden name="operation"
    
                value="<?php echo isset($_GET['operation']) ? $_GET['operation'] : ''; ?>">
            <div>
                <?php if (isset($_GET['operation']) && $_GET['operation'] == 'read'): ?>
                    <label for="read_method">Select Read Method:</label>
                    <select id="read_method" name="read_method">
                        <option value="fread">fread</option>
                        <option value="fgets">fgets</option>
                        <option value="file">file</option>
                        <option value="file_get_contents">file_get_contents</option>
                    </select>
                    <br><br>
                <?php endif; ?>
                <?php if (isset($_GET['operation']) && ($_GET['operation'] == 'write' || $_GET['operation'] == 'append')): ?>
                    <label for="content">Content:</label>
                    <textarea id="content" name="content" rows="4"
                        cols="50"><?php echo isset($_POST['content']) ? htmlspecialchars($_POST['content']) : ''; ?></textarea>
                <?php endif; ?>
                <?php if (isset($_GET['operation']) && $_GET['operation'] == 'copy'): ?>
                    <label for="copyfile">Copy Content To :</label>
                    <input type="text" id="copyfile" name="copyfilename"
                        value="<?php echo isset($_POST['copyfilename']) ? htmlspecialchars($_POST['copyfilename']) : ''; ?>">
                <?php endif; ?>
                <?php if (isset($_GET['operation']) && $_GET['operation'] == 'rename'): ?>
                    <label for="newfilename">Enter New File Name:</label>
                    <input type="text" id="newfilename" name="newfilename"
                        value="<?php echo isset($_POST['newfilename']) ? htmlspecialchars($_POST['newfilename']) : ''; ?>">
                <?php endif; ?>
            </div>

            <button type="submit" name="submit" value="submit">Submit</button>
            <button type="button" id="clearBtn">Clear</button>
        </form>
    </div>
    <div id="container">
        <?php
        if (isset($_POST['filename']) && isset($_POST['operation'])) {
            $filename = $_POST['filename'];
            $operation = $_POST['operation'];

            switch ($operation) {
                case 'read':
                    if (file_exists($filename)) {
                        if (isset($_POST['read_method'])) {
                            echo "<div class='result'>";
                            echo "<h3>File Content:</h3>";
                            echo "<pre>";
                            switch ($_POST['read_method']) {
                                case 'fread':
                                    $file = fopen($filename, "r");
                                    while (!feof($file)) {
                                        echo fread($file, filesize($filename));
                                    }
                                    fclose($file);
                                    break;
                                case 'fgets':
                                    $file = fopen($filename, "r");
                                    while (!feof($file)) {
                                        echo fgets($file);
                                    }
                                    fclose($file);
                                    break;
                                case 'file':
                                    echo file($filename);
                                    break;
                                case 'file_get_contents':
                                    echo file_get_contents($filename);
                                    break;
                                default:
                                    echo "Please select a read method.";
                                    break;
                            }
                            echo "</pre>";
                            echo "</div>";
                        } else {
                            echo "<div class='result'>Please select a read method.</div>";
                        }
                    } else {
                        echo "<div class='result'>File '$filename' does not exist.</div>";
                    }
                    break;

                case 'write':
                    if (isset($_POST['content'])) {
                        $content = $_POST['content'];
                        file_put_contents($filename, $content);
                        echo "<div class='result'>Content written to file '$filename' successfully.</div>";
                    }
                    break;

                case 'append':
                    if (isset($_POST['content'])) {
                        $content = $_POST['content'];
                        file_put_contents($filename, $content, FILE_APPEND);
                        echo "<div class='result'>Content appended to file '$filename' successfully.</div>";
                    }
                    break;

                case 'copy':
                    $new_filename = isset($_POST['copyfilename']) ? $_POST['copyfilename'] : '';
                    if (file_exists($filename)) {

                        if (copy($filename, $new_filename)) {
                            echo "<div class='result'>File '$filename' copied to '$new_filename' successfully.</div>";
                        } else {
                            echo "<div class='result'>Failed to copy file.</div>";
                        }
                    } else {
                        echo "<div class='result'>File '$filename' does not exist.</div>";
                    }
                    break;

                case 'delete':
                    if (file_exists($filename)) {
                        if (unlink($filename)) {
                            echo "<div class='result'>File '$filename' deleted successfully.</div>";
                        } else {
                            echo "<div class='result'>Failed to delete file.</div>";
                        }
                    } else {
                        echo "<div class='result'>File '$filename' does not exist.</div>";
                    }
                    break;

                case 'rename':
                    $new_filename = isset($_POST['newfilename']) ? $_POST['newfilename'] : '';
                    if (file_exists($filename)) {
                        if (rename($filename, $new_filename)) {
                            echo "<div class='result'>File '$filename' renamed to '$new_filename' successfully.</div>";
                        } else {
                            echo "<div class='result'>Failed to rename file.</div>";
                        }
                    } else {
                        echo "<div class='result'>File '$filename' does not exist.</div>";
                    }
                    break;

                case 'permissions':
                    if (file_exists($filename)) {
                        $permissions = fileperms($filename);
                        echo "<div class='result'>Permissions of file '$filename': $permissions</div>";
                    } else {
                        echo "<div class='result'>File '$filename' does not exist.</div>";
                    }
                    break;

                case 'type':
                    if (file_exists($filename)) {
                        $type = filetype($filename);
                        echo "<div class='result'>File type of file '$filename': $type</div>";
                    } else {
                        echo "<div class='result'>File '$filename' does not exist.</div>";
                    }
                    break;

                case 'stats':
                    if (file_exists($filename)) {
                        $stats = stat($filename);
                        echo "<div class='result'>File stats of file '$filename':</div>";
                        echo "<pre>";
                        print_r($stats);
                        echo "</pre>";
                    } else {
                        echo "<div class='result'>File '$filename' does not exist.</div>";
                    }
                    break;

                case 'create':
                    if (!file_exists($filename)) {
                        $file = fopen($filename, "w");
                        fclose($file);
                        echo "<div class='result'>File '$filename' created successfully.</div>";
                    } else {
                        echo "<div class='result'>File '$filename' already exists.</div>";
                    }
                    break;
            }
        }
        ?>
    </div>
</body>

</html>

<script>
    $(document).ready(function () {
        $("#clearBtn").click(function () {
            $("#filename").val("");
            $("#container").empty();
            $("#copyfile").val("");
            $("#content").val("");
        });
    });

</script>