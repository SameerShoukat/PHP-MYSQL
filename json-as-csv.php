function downloadCSV($data)
{
    $filename = "order-report" . date("Y-m-d") . ".csv";

    $f = fopen($filename, 'w');
    fputcsv($f, array_keys($data[0]));
    foreach ($data as $row) {
        fputcsv($f, $row);
    }
    fclose($f);

    return $filename;
}
