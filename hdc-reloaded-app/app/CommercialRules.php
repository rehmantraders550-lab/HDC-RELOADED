<?php
declare(strict_types=1);
final class CommercialRules {
    public static function cataloguePosterCheck(string $slug, array $config): array {
        if (!in_array($slug, ['catalogues','posters'], true)) return ['valid'=>true,'errors'=>[]];
        $errors=[];$quantity=filter_var($config['quantity']??null,FILTER_VALIDATE_INT);
        if ($quantity===false || $quantity<500) $errors[]='Minimum order quantity is 500 pieces.';
        $colors=filter_var($config['print_colors']??null,FILTER_VALIDATE_INT);
        if (!in_array($colors,[1,2,4],true)) $errors[]='Print colors must be 1, 2 or 4.';
        return ['valid'=>!$errors,'errors'=>$errors,'commercial_mode'=>'QUOTE','price_matrix_required'=>true];
    }
    public static function a3SheetBasePrice(string $slug,array $config): ?array {
        if (!in_array($slug,['labels-stickers','custom-sticker-sheets'],true)) return null;
        $size=strtoupper(trim((string)($config['sheet_size']??$config['finished_size']??'')));
        if ($size!=='A3') return null;
        return ['currency'=>'PKR','unit_price'=>2500,'unit'=>'sheet','is_base_price'=>true,'quote_required_for_total'=>true];
    }
    public static function exactApprovedPrice(PDO $pdo,int $productId,array $configuration): ?string {
        ksort($configuration);$configuration=self::canonicalize($configuration);$hash=hash('sha256',json_encode($configuration,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
        $q=$pdo->prepare('SELECT pm.price_pkr FROM price_matrix pm JOIN products p ON p.id=pm.product_id WHERE pm.product_id=? AND pm.configuration_hash=? AND pm.approved=1 AND p.production_approved=1 AND EXISTS (SELECT 1 FROM configuration_profiles cp WHERE cp.product_id=p.id AND cp.approved=1) LIMIT 1');
        $q->execute([$productId,$hash]);$price=$q->fetchColumn();return $price===false?null:(string)$price;
    }
    public static function canonicalize(array $value): array { ksort($value);foreach($value as &$v){if(is_array($v))$v=self::canonicalize($v);}unset($v);return $value; }
    public static function priceHash(array $configuration): string { return hash('sha256',json_encode(self::canonicalize($configuration),JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)); }
    public static function publicProduct(array $p): bool { return $p['status']==='published' && (int)$p['public_visibility']===1 && (int)$p['production_approved']===1; }
}
