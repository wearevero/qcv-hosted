-- melt current status
CREATE OR REPLACE VIEW melt_current_status AS SELECT barcode, max(status) AS status FROM melt_statuses WHERE deleted_at IS NULL GROUP BY barcode ORDER BY barcode;