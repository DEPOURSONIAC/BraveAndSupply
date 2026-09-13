<?php

/**
 * Get a coupon by its code.
 *
 * @param string $code Coupon code.
 *
 * @return array|null Coupon data if found, otherwise null.
 */
function getCouponByCode(string $code): ?array
{
    $db = getPDO();
    $coupon = null;

    try {
        $code = strtoupper(trim($code));

        if ($code !== '') {
            $sql = "SELECT id, code, reduce FROM coupons WHERE code = ? LIMIT 1";

            $stmt = $db->prepare($sql);
            $stmt->execute([$code]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $coupon = $result;
            }
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $coupon;
}


/**
 * Validate a coupon code.
 *
 * @param string $code Coupon code.
 *
 * @return array|null Valid coupon data if valid, otherwise null.
 */
function validateCoupon(string $code): ?array
{
    $valid_coupon = null;

    $code = strtoupper(trim($code));

    if ($code !== '') {
        $coupon = getCouponByCode($code);

        if ($coupon) {
            $reduce = (int) $coupon['reduce'];

            if ($reduce >= 1 && $reduce <= 100) {
                $valid_coupon = $coupon;
            }
        }
    }

    return $valid_coupon;
}


/**
 * Apply a coupon discount to a total.
 *
 * @param float $total Original total price.
 * @param string $code Coupon code.
 *
 * @return float Total price after the discount.
 */
function applyCoupon(float $total, string $code): float
{
    $new_total = $total;

    if ($total >= 0) {
        $coupon = validateCoupon($code);

        if ($coupon) {
            $reduce = (int) $coupon['reduce'];

            $new_total = $total - ($total * $reduce / 100);
            $new_total = max(0, round($new_total, 2));
        }
    }

    return $new_total;
}


/**
 * Create a new coupon.
 *
 * @param string $code Coupon code.
 * @param int $reduce Discount percentage.
 *
 * @return bool True if the coupon was created successfully.
 */
function createCoupon(string $code, int $reduce): bool
{
    $db = getPDO();
    $created = false;

    try {
        $code = strtoupper(trim($code));

        if ($code !== '' && $reduce >= 1 && $reduce <= 100) {
            $sql = "INSERT INTO coupons (code, reduce) VALUES (?, ?)";

            $stmt = $db->prepare($sql);

            $created = $stmt->execute([$code, $reduce]);
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $created;
}


/**
 * Delete a coupon by its code.
 *
 * @param string $code Coupon code.
 *
 * @return bool True if the coupon was deleted successfully.
 */
function deleteCoupon(string $code): bool
{
    $db = getPDO();
    $deleted = false;

    try {
        $code = strtoupper(trim($code));

        if ($code !== '') {
            $sql = "DELETE FROM coupons WHERE code = ?";

            $stmt = $db->prepare($sql);

            $deleted = $stmt->execute([$code]);
        }
    } catch (PDOException $e) {
        error_log(__FUNCTION__ . '(): ' . $e->getMessage());
    }

    return $deleted;
}
