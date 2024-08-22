-- melt current status
-- versi 00 --
CREATE OR REPLACE VIEW melt_current_status AS SELECT barcode, max(status) AS status FROM melt_statuses WHERE deleted_at IS NULL GROUP BY barcode ORDER BY barcode;

-- versi 01 --
CREATE OR REPLACE VIEW melt_current_status AS SELECT melt_statuses.barcode, max(status) AS status, melt_statuses.edited FROM melt_statuses WHERE melt_statuses.status < 6 AND melt_statuses.deleted_at IS NULL GROUP BY barcode, edited ORDER BY barcode;