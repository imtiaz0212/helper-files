// delete duplicate row
DELETE t1 FROM products t1 INNER JOIN products t2 WHERE t1.id < t2.id AND t1.product_name = t2.product_name;

// show duplicate data
SELECT products.product_name, products.product_code, COUNT(*) AS count FROM products GROUP BY product_name HAVING COUNT(*) > 1 

// expload string
SELECT SUBSTRING_INDEX(remark, ':', -1) as voucher_no FROM partytransaction

// store procedure
DROP PROCEDURE IF EXISTS WhileLoop;
DELIMITER $$
CREATE  PROCEDURE   WhileLoop()

BEGIN

set @start = 1;
set @end = 100;
WHILE @start < @end
DO
# LOOP QUERY & INSERT NEW RECORD
INSERT INTO parties VALUES (@start, LPAD(@start, 10, "0"), concat("Authod ", @start), concat("Country ", @start), concat("Address ", @start));

SET @start = @start + 1;
END WHILE;       
END$$
call WhileLoop();


// update stock
INSERT INTO stock (code, name, product_model, product_serial, category, subcategory, quantity, unit, purchase_price, sell_price, godown_code)
SELECT
    pur_item.product_code AS code,
    products.product_name AS name,
    pur_item.product_model,
    pur_item.product_serial,
    products.product_cat AS category,
    products.subcategory,
    SUM(IFNULL(pur_item.pur_quantity, 0) -  IFNULL(purchase_return.pr_quantity, 0) + IFNULL(sale_return.sr_quantity, 0) - IFNULL(sale_item.sale_quantity, 0)) AS stock,
    stock.current_stock,
    pur_item.unit,
    pur_item.purchase_price,
    pur_item.sell_price,
    pur_item.godown_code
FROM (
    SELECT product_code, product_model, product_serial, SUM(quantity) AS pur_quantity, unit, purchase_price, sale_price AS sell_price, godown_code
    FROM sapitems AS pur_item
    WHERE  status= 'purchase' AND trash = 0 GROUP BY product_code
) pur_item
JOIN products ON pur_item.product_code = products.product_code
LEFT JOIN (
    SELECT product_code, SUM(quantity) AS sale_quantity
    FROM sapitems AS sale_item
    WHERE status= 'sale' AND trash = 0 GROUP BY product_code
) sale_item ON pur_item.product_code=sale_item.product_code
LEFT JOIN (
    SELECT product_code, SUM(quantity) AS pr_quantity
    FROM purchase_return
	WHERE 1 GROUP BY product_code
) purchase_return ON pur_item.product_code=purchase_return.product_code
LEFT JOIN (
    SELECT product_code, SUM(quantity) AS sr_quantity
    FROM sale_return
	WHERE trash = 0 GROUP BY product_code
) sale_return ON pur_item.product_code=sale_return.product_code
LEFT JOIN (
    SELECT code, SUM(quantity) AS current_stock
    FROM stock
	WHERE 1 GROUP BY code
) stock ON pur_item.product_code=stock.code
GROUP BY pur_item.product_code




SELECT
    pur_item.product_code AS code,
    products.product_name AS name,
    pur_item.product_model,
    pur_item.product_serial,
    products.product_cat AS category,
    products.subcategory,
    IFNULL(pur_item.pur_quantity, 0) AS pur_quantity,
    IFNULL(purchase_return.pr_quantity, 0) AS pr_quantity,
    IFNULL(sale_return.sr_quantity, 0) AS sr_quantity,
    IFNULL(sale_item.sale_quantity, 0) AS sale_quantity,
    SUM(IFNULL(pur_item.pur_quantity, 0) -  IFNULL(purchase_return.pr_quantity, 0) + IFNULL(sale_return.sr_quantity, 0) - IFNULL(sale_item.sale_quantity, 0)) AS stock,
    IFNULL(stock.quantity, 0) AS current_stock,
    pur_item.unit,
    pur_item.purchase_price,
    pur_item.sell_price,
    pur_item.godown_code
FROM (
    SELECT product_code, product_model, product_serial, SUM(quantity) AS pur_quantity, unit, purchase_price, sale_price AS sell_price, godown_code
    FROM sapitems AS pur_item
    WHERE godown_code='0008' AND status= 'purchase' AND trash = 0 GROUP BY product_code
) pur_item
JOIN products ON pur_item.product_code = products.product_code
LEFT JOIN (
    SELECT product_code, SUM(quantity) AS sale_quantity
    FROM sapitems AS sale_item
    WHERE godown_code='0008' AND status= 'sale' AND trash = 0 GROUP BY product_code
) sale_item ON pur_item.product_code=sale_item.product_code
LEFT JOIN (
    SELECT product_code, SUM(quantity) AS pr_quantity
    FROM purchase_return
	WHERE godown_code='0008' GROUP BY product_code
) purchase_return ON pur_item.product_code=purchase_return.product_code
LEFT JOIN (
    SELECT product_code, SUM(quantity) AS sr_quantity
    FROM sale_return
	WHERE godown_code='0008' AND trash = 0 GROUP BY product_code
) sale_return ON pur_item.product_code=sale_return.product_code
LEFT JOIN (
    SELECT code, quantity
    FROM stock
	WHERE godown_code='0008'
) stock ON pur_item.product_code=stock.code
GROUP BY pur_item.product_code