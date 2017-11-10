<?php

/*
Author dwi.setiyadi@gmail.com
Made for Sirclo
*/

$apiUri = 'http://api.openweathermap.org/data/2.5/forecast/daily';
$apiKey = '481e3bc28e5264e5607c2b65b449bfc1';

function getApi($uri = '')
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $uri);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    
    return $output;
}

if (isset($_POST['q']))
{
    $q = $_POST['q'];
}
else
{
    $q = 'Jakarta';
}

$query = array(
    'q' => $q,
    'mode' => 'json',
    'units' => 'metric',
    'cnt' => 5,
    'APPID' => $apiKey
);

$data = getApi($apiUri . '?' . http_build_query($query));
$data = json_decode($data);

echo '<form action="" method="post">';
echo '<select name="q">';
echo '<option value="Jakarta"' . ($q == 'Jakarta' ? ' selected="selected"' : '') . '>Jakarta</option>';
echo '<option value="Tokyo"' . ($q == 'Tokyo' ? ' selected="selected"' : '') . '>Tokyo</option>';
echo '<option value="London"' . ($q == 'London' ? ' selected="selected"' : '') . '>London</option>';
echo '</select>';
echo '<input type="submit" value="go">';
echo '</form>';

echo '<table style="max-width: 500px;">';
echo '<tr>';
echo '<th>' . $data->city->name . '</th>';
echo '<th>Temperature</th>';
echo '<th>Variance</th>';
echo '</tr>';

$avgtemp = 0;
$avgvar = 0;
foreach ($data->list as $row)
{
    $variance = (float)$row->temp->max - (float)$row->temp->min;
    
    $avgtemp = $avgtemp + (float)$row->temp->day;
    $avgvar = $avgvar + $variance;
    
    echo '<tr>';
    echo '<td>' . date('Y-m-d', $row->dt) . '</td>';
    echo '<td style="text-align: right;">' . $row->temp->day . '&#8451;</td>';
    echo '<td style="text-align: right;">' . $variance . '&#8451;</td>';
    echo '</tr>';
}

$avgtemp = $avgtemp / 5;
$avgtemp = round($avgtemp, 2);

$avgvar = $avgvar / 5;
$avgvar = round($avgvar, 2);

echo '<tr>';
echo '<th>Average</th>';
echo '<th style="text-align: right;">' . $avgtemp . '&#8451;</th>';
echo '<th style="text-align: right;">' . $avgvar . '&#8451;</th>';
echo '</tr>';
echo '</table>';

/* end of file */