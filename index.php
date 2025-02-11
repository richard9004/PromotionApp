<?php 
namespace PromotionApp;
require_once __DIR__ . '/vendor/autoload.php';


use Exads\ABTestData;

class PromotionHandler
{
    private const BASE_URL = 'http://localhost/promotion';

    public function __construct(
        private int $promotionId,
        private array $designPatterns
    ) {
        
    }
   
    // Create an instance using promotion ID and fetch A/B test data
    public static function fromPromotionId(int $promotionId): self
    {
       $designData = new ABTestData($promotionId);
       return new self($promotionId, $designData->getAllDesigns());
    }

    // Select a design based on split percentage probability
    public function getBestConversionDesign(): array
    {
        if(empty($this->designPatterns)){
            return [];
        }

        $random = mt_rand(1, 100);
        $cumulative = 0;

        foreach ($this->designPatterns as $design) { 
          $cumulative += $design['splitPercent'];
          if ($random <= $cumulative) {
            return $design;
          }
        }
        return end($this->designPatterns);
    }
    
    // Redirect user to the selected design page
    public function goToUrl(array $design): void
    {
        $url = $this->generateURL($design);
        header("Location: $url");
        exit;    
    }
   
    // Generate URL for redirection
    private function generateURL(array $design): string
    {
        return self::BASE_URL . '/promotions.php?promo-id=' . $this->promotionId . '&design='. urlencode($design['designName']);
    }
   
}

// Get promotion data and redirect user to a design
$promotionId = 3;
$designPatterns = PromotionHandler::fromPromotionId($promotionId); 
if(empty($designPatterns)){
   echo "No design patterns found for Promotion ID $promotionId";
   exit;
}

$selectedDesign = $designPatterns->getBestConversionDesign();
$designPatterns->goToUrl($selectedDesign);



?>