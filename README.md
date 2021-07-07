# Example import worker from excel

Producer
```php 
use App\Service\ExcelParser;

$file = 'price.xlsx';

$setting = [
    'category' => 'B',
    'name' => 'C',
    'model' => 'D',
    'price' => 'G',
    'quantity' => 'H',
    'manufacturer' => 'F',
    'description' => 'M',
];

$this->load->library('queue');

$excelService = new ExcelParser($setting, $file);

foreach ($excelService->parse() as $product) {
    $this->queue->addTask('import', ['product' => $product]);
}
```