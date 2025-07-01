ALTER TABLE changes
ADD COLUMN request_date_note TEXT NULL AFTER request_date,
ADD COLUMN approval_date_note TEXT NULL AFTER approval_date,
ADD COLUMN uat_date_note TEXT NULL AFTER uat_date,
ADD COLUMN release_date_note TEXT NULL AFTER release_date,
ADD COLUMN target_release_date_note TEXT NULL AFTER target_release_date;
