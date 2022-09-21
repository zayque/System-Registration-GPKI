<?php
// output headers so that the file is downloaded rather than displayed
header('Content-type: text/csv');
header('Content-Disposition: attachment; filename="MaklumatUserSeminar.csv"');
 
// do not cache the file
header('Pragma: no-cache');
header('Expires: 0');
 
// create a file pointer connected to the output stream
$file = fopen('php://output', 'w');
 
// Open the connection
$link = mysqli_connect('localhost', 'root', '', 'sistemborang');
// send the column headers
fputcsv($file, array('Nama', 'Jenis', 'No. KP', 'Peranan', 'Agensi', 'Kementerian', 'Gred', 'No. Tel', 'E-mel','Sistem ICT','Masa'));


//query the database
$query = "SELECT nama_user, jenis, noic_user, peranan_user, agensi_user, kementerian_user, gred_user, notel_user, email_user, sistem_user, masa FROM user WHERE jenis LIKE '%Seminar%'";
 
if ($rows = mysqli_query($link, $query))
{
// loop over the rows, outputting them
while ($row = mysqli_fetch_assoc($rows))
{
fputcsv($file, $row);
}
// free result set
// mysqli_free_result($result);
}
// close the connection
mysqli_close($link);

?>