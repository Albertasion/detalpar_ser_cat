<?php
// //основні посилання категоріі яку вибрали(садова техніка, єлектроинструмент)
// $main_link_trigger = false;

// ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('max_execution_time', 0);
include_once 'functions.php';
require 'vendor/autoload.php';
require 'phpquery.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

define('URL', 'https://detali.org.ua');
$request = requests('https://detali.org.ua/uk/114-zapchasti-dlya-generatorov-i-motoblokov');
$output = phpQuery::newDocument($request);
$menu = $output->find('.top-pagination-content a');
foreach ($menu as $key => $value){
  $pq = pq($value);
  $src_menu[$key] = $pq->attr("href");
}
//удаляємо останній елемент пагинаці. Він веде на 2 сторінку
$trash_page = array_pop($src_menu);
//беремо в масиві останю сторінку
$last_page_url =  end($src_menu);
//розбиваємо останнню сторінку на =
$last_page_number_array = explode("=", $last_page_url);
//дістаємо номер останьої сторінки
$last_page_number= $last_page_number_array[1];
//дістаємо всі можливі сторінки пагінації в змінну $full_url
for ($n = $last_page_number; $n > 0; $n--) {
$full_url = URL.$last_page_number_array[0] . "=". $n;
// echo $full_url. '<br>';
$request_all_pages_paginagination = requests($full_url);
$output_all_pages_paginagination = phpQuery::newDocument($request_all_pages_paginagination);
$all_product_links = $output_all_pages_paginagination->find('.product-name-container a');
foreach ($all_product_links as $key => $value){
  $pq2 = pq($value);
$all_products_links_array[] = $pq2->attr("href");


}

// break;
}

// format ($all_products_links_array);


foreach ($all_products_links_array as $key => $value){
$request_all_product = requests($value);
$output_all_product = phpQuery::newDocument($request_all_product);
// echo $output_all_product;
$product_name = $output_all_product->find('.product-title h1');
$product_sku = $output_all_product->find('.editable');
$product_sku = $product_sku->html();

$product[] = $product_sku;

echo $product_sku.'<br>';




// foreach ()
// echo $product_name.'<br>';
// $pq_product_name = pq($product_name);
// $pq_product_name = $pq_product_name->text();


// echo 'this h1---'. $pq_product_name;
// $product[$key] = $pq_product_name;
// echo $output_all_product;
// if ($key==30)
// break;
 
// $all_products_links_p[$key] = $pq2->attr("href");
}

format ($product);
// $servername = "localhost";
// $database = "detali";
// $username = "parseradmin";
// $password = "1234";
// //Создаем соединение
// $conn = mysqli_connect($servername, $username, $password, $database);
// mysqli_set_charset($conn, "utf8");
// //Проверяем соединение
// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }
// echo "Connected successfull". " ". $database. "<br>";

// // mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


// //Заносимо в базу основни посилання
// if ($main_link_trigger) {     //вмикаємо та вимикаємо початкову загрузку посилань
//   foreach ($src_menu as $k => $v) {
//     foreach ($v as $k2 => $v2) {

//     }
//     $href_item = $src_menu[$k]["href"];
//     $text_link_item = $src_menu[$k]["text_link"];

//     $query = "INSERT INTO detalimenu (id, menulinks, menulinkstext) VALUES (NULL, '$href_item', '$text_link_item')";
//     $result = mysqli_query($conn, $query);
//   }

//   //робимо виборку основних категорий з бази даних
// $query_links = "SELECT menulinks FROM detalimenu";
// $result_links = mysqli_query($conn, $query_links);
// while ($row = mysqli_fetch_assoc($result_links)) {
//   $menulink = $row["menulinks"];
//   //прибираємо з посилання html
//   $menulink_withoot_html = str_replace('.html', "", $menulink);
//   $requestmenu = requests($menulink);
//   $output1 = phpQuery::newDocument($requestmenu);
//   $pagination_link = $output1->find('.pagination');
//   $lastpage_pagination = $output1->find('.last a');
//   foreach ($lastpage_pagination as $key => $value) {
//     $pq1 = pq($value);
//     $last_page[$key]["last_page"] = $pq1->text();
//  for ($n = $last_page[$key]["last_page"]; $n > 0; $n--) {
//       $full_url = $menulink_withoot_html . '/page-' . $n . '.html';
//       echo $full_url . '<br>';
//       $query = "INSERT INTO pages_with_pagination (id, allpages) VALUES (NULL, '$full_url')";
//     $result = mysqli_query($conn, $query);
//     }

//     }
// }


// $query_pages_all = "SELECT allpages FROM pages_with_pagination";
// $result_all_pages = mysqli_query($conn, $query_pages_all);
// while ($row1 = mysqli_fetch_assoc($result_all_pages)) {
//   $all_pages_link = $row1["allpages"];
//   $request_all_pages = requests($all_pages_link);
//   $output2 = phpQuery::newDocument($request_all_pages);

//   $product_link = $output2->find('.title a');

//   foreach ($product_link as $key => $value) {
//     $pq1 = pq($value);
//     $product[$key]["product_link"] = URL . $pq1->attr("href");
//     $product_link = $product[$key]["product_link"];
//     $query3 = "INSERT INTO products (id, products) VALUES (NULL, '$product_link')";
//     $result3 = mysqli_query($conn, $query3);
//     echo $product_link.'<br>';
//   }
// }
// }

// $query_product_all =  "SELECT products FROM products";
// $result_product = mysqli_query($conn, $query_product_all);
// while ($row3 = mysqli_fetch_assoc($result_product))
//   {
//   $product_link = $row3["products"];
//   $request_products = requests($product_link);
//   $html = phpQuery::newDocument($request_products);
//   $product_name = $html->find('h1');
//   $pq4 = pq($product_name);
//   $product[$key]['name'] = trim($pq4->text());

//   $product_sku = $html->find('.sku span:first');
//   $pq5 = pq($product_sku);
//   $product[$key]['sku'] = trim($pq5->text()) . 'STRU';

//   $product_price = $html->find('.price-wrapper');
//   $pq6 = pq($product_price);
//   $product_price_item = trim($pq6->text());
//   $product_price_trim = str_replace(' ', "", $product_price_item);
//   $product_price_trim = str_replace('₴', "", $product_price_trim);
//   $product[$key]['price'] = $product_price_trim;

// $new_price = $html->find('.new-price');
// $pq6 = pq($new_price);
// $product_newprice_item = trim($pq6->text());
// $product_newprice_trim = str_replace(' ', "", $product_price_item);
// $product_newprice_trim = str_replace('₴', "", $product_price_trim);
// $product[$key]['newprice'] = $product_newprice_trim;
//   //phpQuery::unloadDocuments();
  
//   // $spreadsheet = new Spreadsheet();
//   // $sheet = $spreadsheet->getActiveSheet();


//   foreach ($product as $key => $value) {

//     $product_name_item = $product[$key]["name"];
//     $product_sku_item = $product[$key]["sku"];
//     $product_price_item = $product[$key]["price"];
//     $product_newprice_item = $product[$key]["newprice"];
//   echo $product_name_item.'<br>';
//   echo $product_sku_item.'<br>';
//   echo $product_price_item.'<br>';
//   echo $product_newprice_item.'<br>';

//   // $sheet->setCellValue('A'. $key, $value);





//     //закидуем дані про родукт

//     $query_product = "INSERT INTO product_item (id, name, sku, price, newprice) VALUES (NULL, '$product_name_item', '$product_sku_item', '$product_price_item', $product_newprice_item)";
//     $product_result = mysqli_query($conn, $query_product);
//   }
// }
// // $writer = new Xlsx($spreadsheet);
// // $writer->save('Links.xlsx');


// phpQuery::unloadDocuments();


// $query_product_show_all =  "SELECT * products FROM product_item";

// $product_result_show_all = mysqli_query($conn, $query_product_show_all);
// while ($row_all_products = mysqli_fetch_assoc($product_result_show_all)) {
//   $product_link_item_name = $row_all_products["name"];
//   echo $product_link_item_name. '<br>';
  
//}






























//отримуємо головні сабменю
// foreach ($src_menu_formated as $value) {
  // if ($value == 'https://detali.org.ua/uk/102-zapchasti-dlya-betonomeschalki') {
  //   break;
  // }
//   $request_menus = requests($value);
//   $output = phpQuery::newDocument($request_menus);
//   $submenu = $output->find('.subcategory-image a');
//   foreach ($submenu as $key =>$value){
//   $pq = pq($value);
//   $href = $pq->attr("href");
//   $src_submenu[] = $href;
//     echo $src_menu[$key]. '<br>';
// }
// }
// $src_menu_unique = array_unique($src_submenu);
// format($src_menu_unique);
// echo count($src_submenu);
// echo count($src_menu_unique);



// //отримуємо сабменю3
// foreach ($src_submenu as $value) {
  // if ($value == 'https://detali.org.ua/uk/84-zapchasti-dlya-benzopil') {
  //   break;
  // }
//   $request_menus1 = requests($value);
//   $output1 = phpQuery::newDocument($request_menus1);
//   $submenu1 = $output1->find('.subcategory-image a');
//   foreach ($submenu1 as $key =>$value){
//   $pq = pq($value);
//   $src_submenu_category[] = $pq->attr("href");
// }
// }
// echo "Сабменю заповнено";



// //отримуємо сабменю4
// foreach ($src_submenu_category as $value) {
// $request_menus2 = requests($value);
// $output2 = phpQuery::newDocument($request_menus2);
// $submenu2 = $output2->find('.product-name-container a');
//   foreach ($submenu2 as $key =>$value){
//   $pq = pq($value);
//   $src_submenu_category_last[] = $pq->attr("href");
// }
// }
// echo "Сабменю последнее заповнено";





// $spreadsheet = new Spreadsheet();
// $sheet = $spreadsheet->getActiveSheet();
// foreach ($src_menu_formated as $key => $value) {
//   $sheet->setCellValue('A'. $key, $value);
//   }
// foreach ($src_submenu as $key => $value) {
// $sheet->setCellValue('B'. $key, $value);
// }

// foreach ($src_submenu_category as $key => $value) {
//   $sheet->setCellValue('C'. $key, $value);
//   }

//   foreach ($src_submenu_category_last as $key => $value) {
//     $sheet->setCellValue('D'. $key, $value);
//     }


// $writer = new Xlsx($spreadsheet);
// $writer->save('Links.xlsx');
