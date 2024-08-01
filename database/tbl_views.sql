-- melt current status
CREATE OR REPLACE VIEW melt_current_status AS SELECT barcode, max(status) AS status FROM melt_statuses GROUP BY barcode ORDER BY barcode;