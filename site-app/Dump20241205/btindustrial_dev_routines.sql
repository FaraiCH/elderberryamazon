-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: btindustrial-prod-instance-1-cluster.cluster-cvui6jj4ovao.eu-west-1.rds.amazonaws.com    Database: btindustrial_dev
-- ------------------------------------------------------
-- Server version	8.0.34

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED=/*!80000 '+'*/ '';

--
-- Temporary view structure for view `view_srn_vs_schedule_plan`
--

DROP TABLE IF EXISTS `view_srn_vs_schedule_plan`;
/*!50001 DROP VIEW IF EXISTS `view_srn_vs_schedule_plan`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_srn_vs_schedule_plan` AS SELECT 
 1 AS `Quote No`,
 1 AS `SRN No`,
 1 AS `ponumber`,
 1 AS `delivery_date`,
 1 AS `company_name`,
 1 AS `Quote Price`,
 1 AS `HDPE_units_ordered`,
 1 AS `CAT_units_ordered`,
 1 AS `SRN HDPE Weight`,
 1 AS `SRN HDPE Units`,
 1 AS `SRN HDPE Value`,
 1 AS `SRN CAT Units`,
 1 AS `SRN CAT Weight`,
 1 AS `SRN CAT Value`,
 1 AS `estimated_srn_value`,
 1 AS `delivery_type`,
 1 AS `deliveryamount`,
 1 AS `deliveryamounthidden`,
 1 AS `logistics_company`,
 1 AS `Delivery Price By BT`,
 1 AS `Delivery Address 1`,
 1 AS `Delivery Address 2`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_product_production`
--

DROP TABLE IF EXISTS `view_product_production`;
/*!50001 DROP VIEW IF EXISTS `view_product_production`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_product_production` AS SELECT 
 1 AS `id`,
 1 AS `Class`,
 1 AS `Diameter`,
 1 AS `Mass (kg/m)`,
 1 AS `Production Mass (kg/m)`,
 1 AS `od_min`,
 1 AS `od_max`,
 1 AS `ovality_max`,
 1 AS `coil`,
 1 AS `wt_min`,
 1 AS `wt_max`,
 1 AS `Pushed_to_production_Weight`,
 1 AS `Total_price_in_Rands`,
 1 AS `total_kg_processed`,
 1 AS `weight_scrap_kg`,
 1 AS `over_weight_kg`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_materialused`
--

DROP TABLE IF EXISTS `view_materialused`;
/*!50001 DROP VIEW IF EXISTS `view_materialused`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_materialused` AS SELECT 
 1 AS `id`,
 1 AS `schedule_id`,
 1 AS `production_date`,
 1 AS `shift_id`,
 1 AS `controlsheet_id`,
 1 AS `kg_used`,
 1 AS `raw_material_cost`,
 1 AS `material_cost_blend`,
 1 AS `supplier`,
 1 AS `supplier_batch`,
 1 AS `date_of_receipt`,
 1 AS `product_name`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_salesrep_sum`
--

DROP TABLE IF EXISTS `view_salesrep_sum`;
/*!50001 DROP VIEW IF EXISTS `view_salesrep_sum`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_salesrep_sum` AS SELECT 
 1 AS `sales_person`,
 1 AS `totalincvat`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_backorder_by_delivery_hdpe_items`
--

DROP TABLE IF EXISTS `view_backorder_by_delivery_hdpe_items`;
/*!50001 DROP VIEW IF EXISTS `view_backorder_by_delivery_hdpe_items`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_backorder_by_delivery_hdpe_items` AS SELECT 
 1 AS `id`,
 1 AS `quote_id`,
 1 AS `user_id`,
 1 AS `sales_person`,
 1 AS `company_name`,
 1 AS `ponumber`,
 1 AS `quote_date`,
 1 AS `description`,
 1 AS `ordered_price`,
 1 AS `unitprice`,
 1 AS `total_units_ordered`,
 1 AS `total_ordered_sales_weight`,
 1 AS `total_ordered_production_weight`,
 1 AS `no_of_srns`,
 1 AS `total_units_delivered`,
 1 AS `total_stockweight_delivered`,
 1 AS `total_stock_value_delivered`,
 1 AS `dif_units`,
 1 AS `potential_income`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_ControllSheetPlanID`
--

DROP TABLE IF EXISTS `view_ControllSheetPlanID`;
/*!50001 DROP VIEW IF EXISTS `view_ControllSheetPlanID`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_ControllSheetPlanID` AS SELECT 
 1 AS `cs_id`,
 1 AS `quoteitem_id`,
 1 AS `plan_quoteitem_id`,
 1 AS `quote_id`,
 1 AS `plan_quote_id`,
 1 AS `description`,
 1 AS `cs_date`,
 1 AS `plan_date`,
 1 AS `planitemid`,
 1 AS `jobcard_id`,
 1 AS `batch_id`,
 1 AS `plan_id`,
 1 AS `c_plan_id`,
 1 AS `planitem_id`,
 1 AS `c_planid_id`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_quoteitems_data`
--

DROP TABLE IF EXISTS `view_quoteitems_data`;
/*!50001 DROP VIEW IF EXISTS `view_quoteitems_data`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_quoteitems_data` AS SELECT 
 1 AS `quote_date`,
 1 AS `quote_id`,
 1 AS `sales_person`,
 1 AS `company_name`,
 1 AS `ponumber`,
 1 AS `OD`,
 1 AS `pn`,
 1 AS `unitlength`,
 1 AS `unit_weight`,
 1 AS `tonnage_kg`,
 1 AS `unit_price`,
 1 AS `units_total_price`,
 1 AS `rate_per_kg`,
 1 AS `total_units_ordered`,
 1 AS `no_of_srns`,
 1 AS `total_units_delivered`,
 1 AS `total_stock_value_delivered`,
 1 AS `dif_units`,
 1 AS `invoiced_amount`,
 1 AS `inv_perc`,
 1 AS `potential_income`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_backorder_by_delivery_cat_items`
--

DROP TABLE IF EXISTS `view_backorder_by_delivery_cat_items`;
/*!50001 DROP VIEW IF EXISTS `view_backorder_by_delivery_cat_items`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_backorder_by_delivery_cat_items` AS SELECT 
 1 AS `id`,
 1 AS `quote_id`,
 1 AS `user_id`,
 1 AS `sales_person`,
 1 AS `company_name`,
 1 AS `ponumber`,
 1 AS `quote_date`,
 1 AS `description`,
 1 AS `cat_ordered_price`,
 1 AS `unitprice`,
 1 AS `cat_total_units_ordered`,
 1 AS `no_of_srns`,
 1 AS `total_units_delivered`,
 1 AS `total_stock_value_delivered`,
 1 AS `dif_units`,
 1 AS `potential_income`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `new_view_stickerdata`
--

DROP TABLE IF EXISTS `new_view_stickerdata`;
/*!50001 DROP VIEW IF EXISTS `new_view_stickerdata`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `new_view_stickerdata` AS SELECT 
 1 AS `id`,
 1 AS `sticker_scanned_date`,
 1 AS `is_active`,
 1 AS `contronsheet_production_date`,
 1 AS `sticker_production_date`,
 1 AS `stock_age`,
 1 AS `sticker_dispatch_date`,
 1 AS `sticker_age`,
 1 AS `sticker_qcdate`,
 1 AS `controlsheet_id`,
 1 AS `sticker`,
 1 AS `stick_pipe_lenght`,
 1 AS `batch_no`,
 1 AS `quote_no`,
 1 AS `is_scrap`,
 1 AS `qcstatus_id`,
 1 AS `pickslip_id`,
 1 AS `dispatch_date`,
 1 AS `srn_date`,
 1 AS `srn_id`,
 1 AS `st_weight`,
 1 AS `quote_po_number`,
 1 AS `pipesize`,
 1 AS `standardweight`,
 1 AS `shift`,
 1 AS `Baila`,
 1 AS `Batch No`,
 1 AS `company_name`,
 1 AS `ponumber`,
 1 AS `original_order`,
 1 AS `q_unit_price`,
 1 AS `price_per_kg`,
 1 AS `q_unit_length`,
 1 AS `q_units_ordered`,
 1 AS `q_unit_weight`,
 1 AS `delivered_units`,
 1 AS `srns`,
 1 AS `fail_pic`,
 1 AS `qc_status_name`,
 1 AS `scrap_production`,
 1 AS `pn_rating`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_quote_potential_income`
--

DROP TABLE IF EXISTS `view_quote_potential_income`;
/*!50001 DROP VIEW IF EXISTS `view_quote_potential_income`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_quote_potential_income` AS SELECT 
 1 AS `id`,
 1 AS `user_id`,
 1 AS `sales_person`,
 1 AS `company_name`,
 1 AS `ponumber`,
 1 AS `quote_date`,
 1 AS `quote_total_value`,
 1 AS `quote_total_value_incvat`,
 1 AS `total_invoiced`,
 1 AS `count_invoiced`,
 1 AS `total_i_potential_income`,
 1 AS `total_c_potential_income`,
 1 AS `quote_potential_income`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_duplication_of_po_number`
--

DROP TABLE IF EXISTS `view_duplication_of_po_number`;
/*!50001 DROP VIEW IF EXISTS `view_duplication_of_po_number`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_duplication_of_po_number` AS SELECT 
 1 AS `countpo`,
 1 AS `ponumber`,
 1 AS `sales_person`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_electricity_production`
--

DROP TABLE IF EXISTS `view_electricity_production`;
/*!50001 DROP VIEW IF EXISTS `view_electricity_production`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_electricity_production` AS SELECT 
 1 AS `production_date`,
 1 AS `week_id`,
 1 AS `year_id`,
 1 AS `shift_id`,
 1 AS `quote_id`,
 1 AS `description`,
 1 AS `line_id`,
 1 AS `baila`,
 1 AS `controlsheet_id`,
 1 AS `product_id`,
 1 AS `total_weight`,
 1 AS `total_kg_processed`,
 1 AS `weight_scrap_kg`,
 1 AS `over_weight_kg`,
 1 AS `sum_kwh`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_scrapdata`
--

DROP TABLE IF EXISTS `view_scrapdata`;
/*!50001 DROP VIEW IF EXISTS `view_scrapdata`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_scrapdata` AS SELECT 
 1 AS `id`,
 1 AS `cs_run_date_long`,
 1 AS `cs_run_date`,
 1 AS `cs_created_date`,
 1 AS `client`,
 1 AS `shift`,
 1 AS `baila`,
 1 AS `quote_id`,
 1 AS `description`,
 1 AS `class`,
 1 AS `diameter`,
 1 AS `ordered_unitlength`,
 1 AS `ordered_unitweight`,
 1 AS `ordered_totalweight`,
 1 AS `csname`,
 1 AS `batch_no`,
 1 AS `plan_id`,
 1 AS `cs_total_weight`,
 1 AS `total_units_produced`,
 1 AS `weight_scrap_kg`,
 1 AS `over_weight_kg`,
 1 AS `total_kg_processed`,
 1 AS `scrap_perc`,
 1 AS `list_of_codes`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_quote_po_invoiced_by_salesrep`
--

DROP TABLE IF EXISTS `view_quote_po_invoiced_by_salesrep`;
/*!50001 DROP VIEW IF EXISTS `view_quote_po_invoiced_by_salesrep`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_quote_po_invoiced_by_salesrep` AS SELECT 
 1 AS `quote_date`,
 1 AS `quote_id`,
 1 AS `sales_person`,
 1 AS `company_name`,
 1 AS `ponumber`,
 1 AS `totalincvat`,
 1 AS `invoiced_amount`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_srn_units_vs_sticker_units`
--

DROP TABLE IF EXISTS `view_srn_units_vs_sticker_units`;
/*!50001 DROP VIEW IF EXISTS `view_srn_units_vs_sticker_units`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_srn_units_vs_sticker_units` AS SELECT 
 1 AS `id`,
 1 AS `pickslip_id`,
 1 AS `schedule_date`,
 1 AS `quote_id`,
 1 AS `company_name`,
 1 AS `srn_sum_unit`,
 1 AS `count_sicker`,
 1 AS `catalogues_sum_unit`,
 1 AS `srn_created_by`,
 1 AS `created_at`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_ControlSheetMassData`
--

DROP TABLE IF EXISTS `view_ControlSheetMassData`;
/*!50001 DROP VIEW IF EXISTS `view_ControlSheetMassData`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_ControlSheetMassData` AS SELECT 
 1 AS `id`,
 1 AS `csname`,
 1 AS `batch_no`,
 1 AS `cs_created_date`,
 1 AS `cs_run_date`,
 1 AS `quote_id`,
 1 AS `description`,
 1 AS `ordered_units`,
 1 AS `ordered_priceperkg`,
 1 AS `ordered_unitlength`,
 1 AS `ordered_unitweight`,
 1 AS `ordered_totalweight`,
 1 AS `plan_id`,
 1 AS `cs_total_weight`,
 1 AS `shift`,
 1 AS `baila`,
 1 AS `company_name`,
 1 AS `original_order`,
 1 AS `plan_target_qty`,
 1 AS `count_sticker`,
 1 AS `lebo_total_units_passed_qc`,
 1 AS `lebo_total_units_produced`,
 1 AS `lebo_weight_scrap_kg`,
 1 AS `lebo_over_weight_kg`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `report_v_weekly_production`
--

DROP TABLE IF EXISTS `report_v_weekly_production`;
/*!50001 DROP VIEW IF EXISTS `report_v_weekly_production`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `report_v_weekly_production` AS SELECT 
 1 AS `Year`,
 1 AS `Month`,
 1 AS `Week`,
 1 AS `total_kg_processed`,
 1 AS `weight_scrap_kg`,
 1 AS `over_weight_kg`,
 1 AS `Total Waste`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_quote_invoice`
--

DROP TABLE IF EXISTS `view_quote_invoice`;
/*!50001 DROP VIEW IF EXISTS `view_quote_invoice`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_quote_invoice` AS SELECT 
 1 AS `id`,
 1 AS `user_id`,
 1 AS `sales_person`,
 1 AS `company_name`,
 1 AS `ponumber`,
 1 AS `quote_date`,
 1 AS `quote_total_value`,
 1 AS `quote_total_value_incvat`,
 1 AS `invoice_date`,
 1 AS `total_invoiced`,
 1 AS `count_invoiced`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_quote_perfomance`
--

DROP TABLE IF EXISTS `view_quote_perfomance`;
/*!50001 DROP VIEW IF EXISTS `view_quote_perfomance`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_quote_perfomance` AS SELECT 
 1 AS `id`,
 1 AS `push_id`,
 1 AS `sc_id`,
 1 AS `cs_run_date_long`,
 1 AS `client`,
 1 AS `shift`,
 1 AS `baila`,
 1 AS `quote_id`,
 1 AS `description`,
 1 AS `class`,
 1 AS `diameter`,
 1 AS `ordered_units`,
 1 AS `ordered_unitlength`,
 1 AS `ordered_unitweight`,
 1 AS `unitproductionweight`,
 1 AS `ordered_totalweight`,
 1 AS `totalproductionweight`,
 1 AS `ordered_totalcost`,
 1 AS `assigned_cost_zar`,
 1 AS `purge_cost`,
 1 AS `5_p_scrap_ls_spillage_weight`,
 1 AS `5_scrap_ls_spillage_cost`,
 1 AS `sales_purchase_order_value_zar`,
 1 AS `ordered_priceperkg`,
 1 AS `raw_mix_cost`,
 1 AS `total_units_produced`,
 1 AS `planned_pre_pargins_zar`,
 1 AS `planned_pre_margins`,
 1 AS `kgm_production`,
 1 AS `pipe_weight_per_length_target`,
 1 AS `production_total_weight`,
 1 AS `assigned_cost`,
 1 AS `actual_production_cost`,
 1 AS `actual_margins_zar`,
 1 AS `purge_cost_zar`,
 1 AS `weight_scrap_kg`,
 1 AS `lab_sample_weight_kg`,
 1 AS `overrun_weight`,
 1 AS `purge_weight`,
 1 AS `scrap_cost_zar`,
 1 AS `csname`,
 1 AS `batch_no`,
 1 AS `cs_created_date`,
 1 AS `cs_run_date`,
 1 AS `plan_id`,
 1 AS `cs_total_weight`,
 1 AS `company_name`,
 1 AS `original_order`,
 1 AS `plan_target_qty`,
 1 AS `count_sticker`,
 1 AS `lebo_total_units_passed_qc`,
 1 AS `lebo_over_weight_kg`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_QuoteReponse_po`
--

DROP TABLE IF EXISTS `view_QuoteReponse_po`;
/*!50001 DROP VIEW IF EXISTS `view_QuoteReponse_po`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_QuoteReponse_po` AS SELECT 
 1 AS `quote_id`,
 1 AS `ponumber`,
 1 AS `poamount`,
 1 AS `totalincvat`,
 1 AS `billing_name`,
 1 AS `created_at`,
 1 AS `file_name`,
 1 AS `formatted_column`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_weeky_production_vs_electricity`
--

DROP TABLE IF EXISTS `view_weeky_production_vs_electricity`;
/*!50001 DROP VIEW IF EXISTS `view_weeky_production_vs_electricity`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_weeky_production_vs_electricity` AS SELECT 
 1 AS `id`,
 1 AS `Week`,
 1 AS `start_date`,
 1 AS `end_date`,
 1 AS `baila_name`,
 1 AS `total_kg_processed`,
 1 AS `weight_scrap_kg`,
 1 AS `over_weight_kg`,
 1 AS `off_peak_kwh`,
 1 AS `off_peak_amount`,
 1 AS `standard_kwh`,
 1 AS `standard_amount`,
 1 AS `on_peak_kwh`,
 1 AS `on_peak_amount`,
 1 AS `max_demand_amount`,
 1 AS `fixed_charge_amount`,
 1 AS `network_access_amount`,
 1 AS `total_amount`*/;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `view_srn_vs_schedule_plan`
--

/*!50001 DROP VIEW IF EXISTS `view_srn_vs_schedule_plan`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`admin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `view_srn_vs_schedule_plan` AS select `srn`.`quote_id` AS `Quote No`,`srn`.`id` AS `SRN No`,`q`.`ponumber` AS `ponumber`,date_format(`srn`.`schedule_date`,'%Y-%m-%d') AS `delivery_date`,`q`.`company_name` AS `company_name`,`q`.`totalincvat` AS `Quote Price`,`quoteitems`.`HDPE_units_ordered` AS `HDPE_units_ordered`,`catitems`.`CAT_units_ordered` AS `CAT_units_ordered`,sum(`srnitem_out`.`srn_stockweight`) AS `SRN HDPE Weight`,sum(`srnitem_out`.`srn_hdpe_units`) AS `SRN HDPE Units`,sum(`srnitem_out`.`srn_stockvalue`) AS `SRN HDPE Value`,sum(`catitems`.`CAT_units_ordered`) AS `SRN CAT Units`,sum(`srnitem_cat_out`.`srn_cat_stockweight`) AS `SRN CAT Weight`,sum(`srnitem_cat_out`.`srn_cat_stockvalue`) AS `SRN CAT Value`,(sum(`srnitem_out`.`srn_stockvalue`) + sum(`srnitem_cat_out`.`srn_cat_stockvalue`)) AS `estimated_srn_value`,`stype`.`name` AS `delivery_type`,`q`.`deliveryamount` AS `deliveryamount`,`q`.`deliveryamounthidden` AS `deliveryamounthidden`,`srn`.`logistics_company` AS `logistics_company`,`srn`.`deliveryprice` AS `Delivery Price By BT`,replace(replace(`srn`.`delivery_address`,'\n                ',' '),'\r','') AS `Delivery Address 1`,replace(replace(`cl`.`physical_address`,'\n                ',' '),'\r','') AS `Delivery Address 2` from (((((((`bt_sales_srns` `srn` join `bt_sales_newquote` `q` on((`srn`.`quote_id` = `q`.`id`))) left join (select `srnitem_in`.`srn_id` AS `srn_id_in`,sum(`srnitem_in`.`stockweight`) AS `srn_stockweight`,sum(`srnitem_in`.`stockvalue`) AS `srn_stockvalue`,sum(`srnitem_in`.`units`) AS `srn_hdpe_units` from `bt_sales_srn_items` `srnitem_in` group by `srnitem_in`.`created_at`) `srnitem_out` on((`srnitem_out`.`srn_id_in` = `srn`.`id`))) left join (select `srnitem_cat_in`.`srn_id` AS `srn_cat_id_in`,sum(`srnitem_cat_in`.`stockweight`) AS `srn_cat_stockweight`,sum(`srnitem_cat_in`.`stockvalue`) AS `srn_cat_stockvalue` from `bt_sales_srn_catalogues` `srnitem_cat_in` group by `srnitem_cat_in`.`created_at`) `srnitem_cat_out` on((`srnitem_cat_out`.`srn_cat_id_in` = `srn`.`id`))) left join (select `bt_sales_quoteitems`.`quote_id` AS `quote_id`,sum(`bt_sales_quoteitems`.`units`) AS `HDPE_units_ordered` from `bt_sales_quoteitems` group by `bt_sales_quoteitems`.`quote_id`) `quoteitems` on((`quoteitems`.`quote_id` = `q`.`id`))) left join (select `bt_sales_quote_item_catalogues`.`quote_id` AS `quote_id`,sum(`bt_sales_quote_item_catalogues`.`units`) AS `CAT_units_ordered` from `bt_sales_quote_item_catalogues` group by `bt_sales_quote_item_catalogues`.`quote_id`) `catitems` on((`catitems`.`quote_id` = `q`.`id`))) join `bt_sales_delivery_types` `stype` on((`stype`.`id` = `srn`.`type_id`))) join `bt_sales_clients` `cl` on((`cl`.`id` = `srn`.`client_id`))) where (`srn`.`schedule_date` > '2023-01-01 00:00:01') group by `srn`.`created_at` order by `srn`.`schedule_date` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_product_production`
--

/*!50001 DROP VIEW IF EXISTS `view_product_production`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`admin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `view_product_production` AS select `prod`.`id` AS `id`,`rat`.`name` AS `Class`,`dia`.`name` AS `Diameter`,`prod`.`value` AS `Mass (kg/m)`,`prod`.`production_value` AS `Production Mass (kg/m)`,`prod`.`od_min` AS `od_min`,`prod`.`od_max` AS `od_max`,`prod`.`ovality_max` AS `ovality_max`,`prod`.`coil` AS `coil`,`prod`.`wt_min` AS `wt_min`,`prod`.`wt_max` AS `wt_max`,`proddata`.`ordered_weight` AS `Pushed_to_production_Weight`,`proddata`.`sum_price` AS `Total_price_in_Rands`,`sced_data`.`total_kg_processed` AS `total_kg_processed`,`sced_data`.`weight_scrap_kg` AS `weight_scrap_kg`,`sced_data`.`over_weight_kg` AS `over_weight_kg` from ((((`bt_sales_products` `prod` join `bt_sales_diameters` `dia` on((`dia`.`id` = `prod`.`diameter_id`))) join `bt_sales_p_n_ratings` `rat` on((`rat`.`id` = `prod`.`pn_ratings_id`))) left join (select sum(`qi`.`totalweight`) AS `ordered_weight`,`qi`.`product_id` AS `product_id`,sum(`qi`.`price`) AS `sum_price` from ((`bt_sales_quoteitems` `qi` join `bt_sales_newquote` `q` on((`q`.`id` = `qi`.`quote_id`))) join `bt_production_pipes` `pp` on((`pp`.`quoteitem_id` = `qi`.`id`))) where ((`qi`.`quote_id` <> 284) and (`pp`.`start_date` > '2023-02-28')) group by `qi`.`product_id`) `proddata` on((`proddata`.`product_id` = `prod`.`id`))) left join (select `qi`.`product_id` AS `sprodid`,sum(`sc`.`total_kg_processed`) AS `total_kg_processed`,sum(`sc`.`weight_scrap_kg`) AS `weight_scrap_kg`,sum(`sc`.`over_weight_kg`) AS `over_weight_kg` from ((`bt_production_schedules` `sc` join `bt_production_pipes` `pp` on((`pp`.`id` = `sc`.`pipe_id`))) join `bt_sales_quoteitems` `qi` on((`qi`.`id` = `pp`.`quoteitem_id`))) where ((`qi`.`quote_id` <> 284) and (`sc`.`production_date` > '2023-02-28')) group by `qi`.`product_id`) `sced_data` on((`sced_data`.`sprodid` = `prod`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_materialused`
--

/*!50001 DROP VIEW IF EXISTS `view_materialused`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`admin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `view_materialused` AS select `mused`.`id` AS `id`,`mused`.`schedule_id` AS `schedule_id`,`sc`.`production_date` AS `production_date`,`sc`.`shift_id` AS `shift_id`,`sc`.`controlsheet_id` AS `controlsheet_id`,`mused`.`kg` AS `kg_used`,`sc`.`raw_material_cost` AS `raw_material_cost`,(`mused`.`kg` * `sc`.`raw_material_cost`) AS `material_cost_blend`,`sup`.`name` AS `supplier`,`mr`.`supplier_batch` AS `supplier_batch`,`mr`.`date_of_receipt` AS `date_of_receipt`,`pname`.`name` AS `product_name` from ((((`bt_production_material_useds` `mused` join `bt_inventory_raw_material_receivings` `mr` on((`mr`.`id` = `mused`.`raw_material_receivings_id`))) join `bt_inventory_part_names` `pname` on((`pname`.`id` = `mr`.`part_name_id`))) join `bt_inventory_suppliers` `sup` on((`sup`.`id` = `pname`.`supplier_id`))) join `bt_production_schedules` `sc` on((`sc`.`id` = `mused`.`schedule_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_salesrep_sum`
--

/*!50001 DROP VIEW IF EXISTS `view_salesrep_sum`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`admin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `view_salesrep_sum` AS select concat(`users`.`name`,' ',`users`.`surname`) AS `sales_person`,sum(`q`.`totalincvat`) AS `totalincvat` from (`bt_sales_newquote` `q` join `users` on((`users`.`id` = `q`.`user_id`))) where ((`q`.`ponumber` is not null) and (`q`.`ponumber` <> '') and (cast(`q`.`created_at` as date) >= cast('2023-03-01' as date))) group by `q`.`user_id` order by `q`.`id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_backorder_by_delivery_hdpe_items`
--

/*!50001 DROP VIEW IF EXISTS `view_backorder_by_delivery_hdpe_items`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`admin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `view_backorder_by_delivery_hdpe_items` AS select `qi`.`id` AS `id`,`qi`.`quote_id` AS `quote_id`,`q`.`user_id` AS `user_id`,concat(`users`.`name`,' ',`users`.`surname`) AS `sales_person`,`q`.`company_name` AS `company_name`,`q`.`ponumber` AS `ponumber`,`q`.`created_at` AS `quote_date`,`qi`.`description` AS `description`,`qi`.`price` AS `ordered_price`,`qi`.`unitprice` AS `unitprice`,coalesce(`qi`.`units`,0) AS `total_units_ordered`,`qi`.`totalweight` AS `total_ordered_sales_weight`,`qi`.`totalproductionweight` AS `total_ordered_production_weight`,`srnitems`.`no_of_srns` AS `no_of_srns`,coalesce(`srnitems`.`total_units_delivered`,0) AS `total_units_delivered`,`srnitems`.`total_stockweight_delivered` AS `total_stockweight_delivered`,`srnitems`.`total_stock_value_delivered` AS `total_stock_value_delivered`,(coalesce(`qi`.`units`,0) - coalesce(`srnitems`.`total_units_delivered`,0)) AS `dif_units`,((coalesce(`qi`.`units`,0) - coalesce(`srnitems`.`total_units_delivered`,0)) * coalesce(`qi`.`unitprice`,0)) AS `potential_income` from (((`bt_sales_quoteitems` `qi` join `bt_sales_newquote` `q` on((`q`.`id` = `qi`.`quote_id`))) join `users` on((`users`.`id` = `q`.`user_id`))) left join (select `srn`.`quote_id` AS `quote_id`,count(`srni`.`srn_id`) AS `no_of_srns`,sum(`srni`.`units`) AS `total_units_delivered`,sum(`srni`.`stockweight`) AS `total_stockweight_delivered`,sum(`srni`.`stockvalue`) AS `total_stock_value_delivered`,`qi`.`product_id` AS `temp_product_id`,`qi`.`unitlength` AS `temp_unitlength` from ((`bt_sales_srn_items` `srni` join `bt_sales_quoteitems` `qi` on((`qi`.`id` = `srni`.`quoteitem_id`))) join `bt_sales_srns` `srn` on((`srn`.`id` = `srni`.`srn_id`))) group by `srn`.`quote_id`,`qi`.`product_id`,`qi`.`unitlength`) `srnitems` on(((`srnitems`.`quote_id` = `qi`.`quote_id`) and (`srnitems`.`temp_product_id` = `qi`.`product_id`) and (`srnitems`.`temp_unitlength` = `qi`.`unitlength`)))) where ((`q`.`ponumber` is not null) and (`q`.`ponumber` <> '') and (coalesce(`srnitems`.`total_units_delivered`,0) < coalesce(`qi`.`units`,0))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_ControllSheetPlanID`
--

/*!50001 DROP VIEW IF EXISTS `view_ControllSheetPlanID`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`admin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `view_ControllSheetPlanID` AS select `cs`.`id` AS `cs_id`,`p`.`quoteitem_id` AS `quoteitem_id`,`plani`.`item_id` AS `plan_quoteitem_id`,`qi`.`quote_id` AS `quote_id`,`plani`.`quote_id` AS `plan_quote_id`,`qi`.`description` AS `description`,cast(`cs`.`opendate` as date) AS `cs_date`,cast(`plan`.`startdate` as date) AS `plan_date`,`plani`.`id` AS `planitemid`,`cs`.`jobcard_id` AS `jobcard_id`,`cs`.`batch_id` AS `batch_id`,`cs`.`plan_id` AS `plan_id`,`plan`.`id` AS `c_plan_id`,`cs`.`planitem_id` AS `planitem_id`,`plani`.`id` AS `c_planid_id` from (((((`bt_production_control_sheets` `cs` join `bt_production_jobcards` `jc` on((`jc`.`id` = `cs`.`jobcard_id`))) join `bt_production_pipes` `p` on((`p`.`id` = `jc`.`pipe_id`))) join `bt_sales_quoteitems` `qi` on((`qi`.`id` = `p`.`quoteitem_id`))) join `bt_production_production_plan_items` `plani` on((`plani`.`item_id` = `p`.`quoteitem_id`))) join `bt_production_production_plans` `plan` on((`plan`.`id` = `plani`.`plan_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_quoteitems_data`
--

/*!50001 DROP VIEW IF EXISTS `view_quoteitems_data`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`admin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `view_quoteitems_data` AS select cast(`q`.`created_at` as date) AS `quote_date`,`qi`.`quote_id` AS `quote_id`,concat(`users`.`name`,' ',`users`.`surname`) AS `sales_person`,`q`.`company_name` AS `company_name`,`q`.`ponumber` AS `ponumber`,`d`.`name` AS `OD`,`pnrating`.`name` AS `pn`,cast(`qi`.`unitlength` as signed) AS `unitlength`,`qi`.`weight` AS `unit_weight`,`qi`.`totalweight` AS `tonnage_kg`,`qi`.`unitprice` AS `unit_price`,`qi`.`price` AS `units_total_price`,`qi`.`priceperkg` AS `rate_per_kg`,coalesce(`qi`.`units`,0) AS `total_units_ordered`,`srnitems`.`no_of_srns` AS `no_of_srns`,coalesce(`srnitems`.`total_units_delivered`,0) AS `total_units_delivered`,`srnitems`.`total_stock_value_delivered` AS `total_stock_value_delivered`,(coalesce(`qi`.`units`,0) - coalesce(`srnitems`.`total_units_delivered`,0)) AS `dif_units`,`inv`.`invoiced_amount` AS `invoiced_amount`,cast(((coalesce(`q`.`totalincvat`,0) / coalesce(`inv`.`invoiced_amount`,0)) * 100) as signed) AS `inv_perc`,((coalesce(`qi`.`units`,0) - coalesce(`srnitems`.`total_units_delivered`,0)) * coalesce(`qi`.`unitprice`,0)) AS `potential_income` from (((((((`bt_sales_quoteitems` `qi` join `bt_sales_newquote` `q` on((`q`.`id` = `qi`.`quote_id`))) join `users` on((`users`.`id` = `q`.`user_id`))) left join (select `srn`.`quote_id` AS `quote_id`,count(`srni`.`srn_id`) AS `no_of_srns`,sum(`srni`.`units`) AS `total_units_delivered`,sum(`srni`.`stockweight`) AS `total_stockweight_delivered`,sum(`srni`.`stockvalue`) AS `total_stock_value_delivered`,`qi`.`product_id` AS `temp_product_id`,`qi`.`unitlength` AS `temp_unitlength` from ((`bt_sales_srn_items` `srni` join `bt_sales_quoteitems` `qi` on((`qi`.`id` = `srni`.`quoteitem_id`))) join `bt_sales_srns` `srn` on((`srn`.`id` = `srni`.`srn_id`))) group by `srn`.`quote_id`,`qi`.`product_id`,`qi`.`unitlength`) `srnitems` on(((`srnitems`.`quote_id` = `qi`.`quote_id`) and (`srnitems`.`temp_product_id` = `qi`.`product_id`) and (`srnitems`.`temp_unitlength` = `qi`.`unitlength`)))) join `bt_sales_products` `p` on((`p`.`id` = `qi`.`product_id`))) join `bt_sales_diameters` `d` on((`d`.`id` = `p`.`diameter_id`))) join `bt_sales_p_n_ratings` `pnrating` on((`pnrating`.`id` = `p`.`pn_ratings_id`))) left join (select `bt_sales_invoices`.`quote_id` AS `quote_id`,sum(`bt_sales_invoices`.`amount`) AS `invoiced_amount` from `bt_sales_invoices` group by `bt_sales_invoices`.`quote_id`) `inv` on((`inv`.`quote_id` = `q`.`id`))) where ((`q`.`ponumber` is not null) and (`q`.`ponumber` <> '') and (cast(`q`.`created_at` as date) >= cast('2023-01-01' as date))) order by `qi`.`quote_id` limit 2000000 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_backorder_by_delivery_cat_items`
--

/*!50001 DROP VIEW IF EXISTS `view_backorder_by_delivery_cat_items`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`admin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `view_backorder_by_delivery_cat_items` AS select `qit`.`id` AS `id`,`qit`.`quote_id` AS `quote_id`,`q`.`user_id` AS `user_id`,concat(`users`.`name`,' ',`users`.`surname`) AS `sales_person`,`q`.`company_name` AS `company_name`,`q`.`ponumber` AS `ponumber`,`q`.`created_at` AS `quote_date`,`qit`.`description` AS `description`,`qit`.`price` AS `cat_ordered_price`,coalesce(`qit`.`unitprice`,0) AS `unitprice`,coalesce(`qit`.`units`,0) AS `cat_total_units_ordered`,`srncatitems`.`no_of_srns` AS `no_of_srns`,coalesce(`srncatitems`.`total_units_delivered`,0) AS `total_units_delivered`,`srncatitems`.`total_stock_value_delivered` AS `total_stock_value_delivered`,(coalesce(`qit`.`units`,0) - coalesce(`srncatitems`.`total_units_delivered`,0)) AS `dif_units`,((coalesce(`qit`.`units`,0) - coalesce(`srncatitems`.`total_units_delivered`,0)) * coalesce(`qit`.`unitprice`,0)) AS `potential_income` from (((`bt_sales_quote_item_catalogues` `qit` join `bt_sales_newquote` `q` on((`q`.`id` = `qit`.`quote_id`))) join `users` on((`users`.`id` = `q`.`user_id`))) left join (select `bt_sales_srn_catalogues`.`quotecat_id` AS `quotecat_id`,count(`bt_sales_srn_catalogues`.`srn_id`) AS `no_of_srns`,sum(`bt_sales_srn_catalogues`.`units`) AS `total_units_delivered`,sum(`bt_sales_srn_catalogues`.`stockvalue`) AS `total_stock_value_delivered` from `bt_sales_srn_catalogues` group by `bt_sales_srn_catalogues`.`quotecat_id`) `srncatitems` on((`srncatitems`.`quotecat_id` = `qit`.`id`))) where ((`q`.`ponumber` is not null) and (`q`.`ponumber` <> '') and (coalesce(`srncatitems`.`total_units_delivered`,0) < coalesce(`qit`.`units`,0))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `new_view_stickerdata`
--

/*!50001 DROP VIEW IF EXISTS `new_view_stickerdata`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`admin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `new_view_stickerdata` AS select `st`.`id` AS `id`,`st`.`sticker_scanned_date` AS `sticker_scanned_date`,`st`.`is_active` AS `is_active`,`cs`.`opendate` AS `contronsheet_production_date`,`st`.`production_date` AS `sticker_production_date`,(to_days(now()) - to_days(`st`.`production_date`)) AS `stock_age`,`st`.`dispatch_date` AS `sticker_dispatch_date`,(to_days(now()) - to_days(`st`.`dispatch_date`)) AS `sticker_age`,`st`.`qcdate` AS `sticker_qcdate`,`st`.`controlsheet_id` AS `controlsheet_id`,concat(' ',`st`.`sticker_id`,'-',`st`.`counter`) AS `sticker`,round(`st`.`unit_length`,0) AS `stick_pipe_lenght`,concat(' ',convert(lpad(`cs`.`jobcard_id`,4,0) using utf8mb4),'-',convert(lpad(`cs`.`batch_id`,4,0) using utf8mb4)) AS `batch_no`,`qi`.`quote_id` AS `quote_no`,`st`.`is_scrap` AS `is_scrap`,`st`.`qcstatus_id` AS `qcstatus_id`,`st`.`pickslip_id` AS `pickslip_id`,`st`.`dispatch_date` AS `dispatch_date`,`st`.`srn_date` AS `srn_date`,`st`.`srn_id` AS `srn_id`,`st`.`weight` AS `st_weight`,`q`.`ponumber` AS `quote_po_number`,`cs`.`pipesize` AS `pipesize`,`cs`.`standardweight` AS `standardweight`,`cs`.`shift` AS `shift`,`line`.`name` AS `Baila`,concat(`cs`.`jobcard_id`,'-',`cs`.`batch_id`) AS `Batch No`,`q`.`company_name` AS `company_name`,`q`.`ponumber` AS `ponumber`,`qi`.`description` AS `original_order`,`qi`.`unitprice` AS `q_unit_price`,`qi`.`priceperkg` AS `price_per_kg`,round(`qi`.`unitlength`,0) AS `q_unit_length`,`qi`.`units` AS `q_units_ordered`,`qi`.`weight` AS `q_unit_weight`,`srn`.`delivered_units` AS `delivered_units`,`srn`.`SRNS` AS `srns`,concat('https://bailaerp.bt-industrial.co.za/storage/app/uploads/public/',substr(`f`.`disk_name`,1,3),'/',substr(`f`.`disk_name`,4,3),'/',substr(`f`.`disk_name`,7,3),'/',`f`.`disk_name`) AS `fail_pic`,(case when (`st`.`qcstatus_id` = 1) then 'Pass' when (`st`.`qcstatus_id` = 2) then 'Fail' when (`st`.`qcstatus_id` = 3) then 'On Hold' when (`st`.`qcstatus_id` = 4) then 'Scrap' else 'Pass' end) AS `qc_status_name`,(case when (`st`.`is_scrap` = 0) then 'No' when (`st`.`is_scrap` = 1) then 'Yes' end) AS `scrap_production`,`pn`.`name` AS `pn_rating` from ((((((((((`bt_production_pipestickeritems` `st` join `bt_production_control_sheets` `cs` on((`cs`.`id` = `st`.`controlsheet_id`))) join `bt_production_lines` `line` on((`line`.`id` = `cs`.`line_id`))) join `bt_production_jobcards` `jc` on((`jc`.`id` = `cs`.`jobcard_id`))) join `bt_production_pipes` `pipe` on((`pipe`.`id` = `jc`.`pipe_id`))) join `bt_sales_quoteitems` `qi` on((`qi`.`id` = `pipe`.`quoteitem_id`))) join `bt_sales_newquote` `q` on((`q`.`id` = `qi`.`quote_id`))) join `bt_sales_products` `p` on((`p`.`id` = `qi`.`product_id`))) join `bt_sales_p_n_ratings` `pn` on((`pn`.`id` = `p`.`pn_ratings_id`))) left join `system_files` `f` on(((`f`.`attachment_id` = `st`.`id`) and (`f`.`field` = 'fail_pic') and (`f`.`attachment_type` like '%Pipestickeritem%')))) left join (select `bt_sales_srn_items`.`quoteitem_id` AS `quoteitem_id`,sum(`bt_sales_srn_items`.`units`) AS `delivered_units`,group_concat(`bt_sales_srn_items`.`srn_id` separator ',') AS `SRNS` from `bt_sales_srn_items` group by `bt_sales_srn_items`.`quoteitem_id`) `srn` on((`srn`.`quoteitem_id` = `qi`.`id`))) order by `st`.`controlsheet_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_quote_potential_income`
--

/*!50001 DROP VIEW IF EXISTS `view_quote_potential_income`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`admin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `view_quote_potential_income` AS select `q`.`id` AS `id`,`q`.`user_id` AS `user_id`,concat(`users`.`name`,' ',`users`.`surname`) AS `sales_person`,`q`.`company_name` AS `company_name`,`q`.`ponumber` AS `ponumber`,`q`.`created_at` AS `quote_date`,`q`.`total` AS `quote_total_value`,`q`.`totalincvat` AS `quote_total_value_incvat`,coalesce(`inv`.`total_invoiced`,0) AS `total_invoiced`,`inv`.`count_invoiced` AS `count_invoiced`,coalesce(`potdataitems`.`total_i_potential_income`,0) AS `total_i_potential_income`,coalesce(`potdatacatitems`.`total_c_potential_income`,0) AS `total_c_potential_income`,(coalesce(`potdataitems`.`total_i_potential_income`,0) + coalesce(`potdatacatitems`.`total_c_potential_income`,0)) AS `quote_potential_income` from ((((`bt_sales_newquote` `q` join `users` on((`users`.`id` = `q`.`user_id`))) left join (select `view_backorder_by_delivery_hdpe_items`.`quote_id` AS `quote_id`,sum(`view_backorder_by_delivery_hdpe_items`.`potential_income`) AS `total_i_potential_income` from `view_backorder_by_delivery_hdpe_items` group by `view_backorder_by_delivery_hdpe_items`.`quote_id`) `potdataitems` on((`potdataitems`.`quote_id` = `q`.`id`))) left join (select `view_backorder_by_delivery_cat_items`.`quote_id` AS `quote_id`,sum(`view_backorder_by_delivery_cat_items`.`potential_income`) AS `total_c_potential_income` from `view_backorder_by_delivery_cat_items` group by `view_backorder_by_delivery_cat_items`.`quote_id`) `potdatacatitems` on((`potdatacatitems`.`quote_id` = `q`.`id`))) left join (select `inv`.`quote_id` AS `quote_id`,sum(`inv`.`amount`) AS `total_invoiced`,count(`inv`.`quote_id`) AS `count_invoiced` from `bt_sales_invoices` `inv` group by `inv`.`quote_id`) `inv` on((`inv`.`quote_id` = `q`.`id`))) where ((`q`.`ponumber` is not null) and (`q`.`ponumber` <> '') and ((coalesce(`potdataitems`.`total_i_potential_income`,0) + coalesce(`potdatacatitems`.`total_c_potential_income`,0)) > 0)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_duplication_of_po_number`
--

/*!50001 DROP VIEW IF EXISTS `view_duplication_of_po_number`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`admin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `view_duplication_of_po_number` AS select count(`q`.`ponumber`) AS `countpo`,`q`.`ponumber` AS `ponumber`,concat(`users`.`name`,' ',`users`.`surname`) AS `sales_person` from (`bt_sales_newquote` `q` join `users` on((`users`.`id` = `q`.`user_id`))) where ((`q`.`ponumber` is not null) and (`q`.`ponumber` <> '') and (cast(`q`.`created_at` as date) >= cast('2023-03-01' as date))) group by `q`.`ponumber` having (count(`q`.`ponumber`) > 1) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_electricity_production`
--

/*!50001 DROP VIEW IF EXISTS `view_electricity_production`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`admin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `view_electricity_production` AS select cast(`sc`.`production_date` as date) AS `production_date`,week(`sc`.`production_date`,0) AS `week_id`,year(`sc`.`production_date`) AS `year_id`,`sc`.`shift_id` AS `shift_id`,`qi`.`quote_id` AS `quote_id`,`qi`.`description` AS `description`,`cs`.`line_id` AS `line_id`,`btline`.`name` AS `baila`,`sc`.`controlsheet_id` AS `controlsheet_id`,`qi`.`product_id` AS `product_id`,`cs`.`total_weight` AS `total_weight`,sum(`sc`.`total_kg_processed`) AS `total_kg_processed`,sum(`sc`.`weight_scrap_kg`) AS `weight_scrap_kg`,sum(`sc`.`over_weight_kg`) AS `over_weight_kg`,`elecdata`.`sum_kwh` AS `sum_kwh` from (((((((`bt_production_schedules` `sc` join `bt_production_pipes` `pp` on((`pp`.`id` = `sc`.`pipe_id`))) join `bt_sales_quoteitems` `qi` on((`qi`.`id` = `pp`.`quoteitem_id`))) join `bt_production_control_sheets` `cs` on((`cs`.`id` = `sc`.`controlsheet_id`))) join `bt_production_lines` `btline` on((`btline`.`id` = `cs`.`line_id`))) join `bt_production_jobcards` `jc` on((`jc`.`id` = `cs`.`jobcard_id`))) join `bt_production_pipes` `pipe` on((`pipe`.`id` = `jc`.`pipe_id`))) left join (select `elec`.`rdate` AS `rdate`,`elec`.`shift_id` AS `shift_id`,`elec`.`meter_no` AS `meter_no`,sum(`elec`.`kwh`) AS `sum_kwh` from `bt_maintenance_electricities` `elec` where (`elec`.`rdate` > '2023-01-01') group by `elec`.`rdate`,`elec`.`shift_id`,`elec`.`meter_no` order by `elec`.`rdate`) `elecdata` on(((`elecdata`.`meter_no` = `btline`.`bt_meter_id`) and (cast(`elecdata`.`rdate` as date) = cast(`sc`.`production_date` as date)) and (`elecdata`.`shift_id` = `sc`.`shift_id`)))) where ((`sc`.`production_date` > '2023-01-01') and (`sc`.`controlsheet_id` is not null) and (`qi`.`quote_id` <> 284)) group by `sc`.`controlsheet_id` order by `sc`.`production_date` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_scrapdata`
--

/*!50001 DROP VIEW IF EXISTS `view_scrapdata`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`admin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `view_scrapdata` AS select `cs`.`id` AS `id`,concat(convert(dayname(`cs`.`opendate`) using utf8mb4),', ',convert(lpad(dayofmonth(`cs`.`opendate`),2,'0') using utf8mb4),' ',convert(monthname(`cs`.`opendate`) using utf8mb4),' ',year(`cs`.`opendate`)) AS `cs_run_date_long`,`cs`.`opendate` AS `cs_run_date`,`cs`.`created_at` AS `cs_created_date`,`q`.`company_name` AS `client`,`cs`.`shift` AS `shift`,`line`.`name` AS `baila`,`qi`.`quote_id` AS `quote_id`,`qi`.`description` AS `description`,`rat`.`name` AS `class`,`dia`.`name` AS `diameter`,`qi`.`unitlength` AS `ordered_unitlength`,`qi`.`weight` AS `ordered_unitweight`,`qi`.`totalweight` AS `ordered_totalweight`,concat(`cs`.`jobcard_id`,', #',`cs`.`jobcard_id`,'-',`cs`.`batch_id`) AS `csname`,concat(`cs`.`jobcard_id`,'-',`cs`.`batch_id`) AS `batch_no`,`cs`.`plan_id` AS `plan_id`,`cs`.`total_weight` AS `cs_total_weight`,`schdata`.`total_units_produced` AS `total_units_produced`,`schdata`.`weight_scrap_kg` AS `weight_scrap_kg`,`schdata`.`over_weight_kg` AS `over_weight_kg`,`schdata`.`total_kg_processed` AS `total_kg_processed`,`schdata`.`scrap_perc` AS `scrap_perc`,`schdata`.`list_of_codes` AS `list_of_codes` from (((((((((((`bt_production_control_sheets` `cs` join `bt_production_jobcards` `jc` on((`jc`.`id` = `cs`.`jobcard_id`))) join `bt_production_pipes` `p` on((`p`.`id` = `jc`.`pipe_id`))) join `bt_sales_quoteitems` `qi` on((`qi`.`id` = `p`.`quoteitem_id`))) join `bt_production_lines` `line` on((`line`.`id` = `cs`.`line_id`))) join `bt_sales_newquote` `q` on((`q`.`id` = `qi`.`quote_id`))) join `bt_sales_products` `prod` on((`prod`.`id` = `qi`.`product_id`))) join `bt_sales_diameters` `dia` on((`dia`.`id` = `prod`.`diameter_id`))) join `bt_sales_p_n_ratings` `rat` on((`rat`.`id` = `prod`.`pn_ratings_id`))) left join (select `new_view_stickerdata`.`controlsheet_id` AS `controlsheet_id`,count(`new_view_stickerdata`.`controlsheet_id`) AS `count_sticker`,`new_view_stickerdata`.`shift` AS `shift`,`new_view_stickerdata`.`Baila` AS `baila`,`new_view_stickerdata`.`company_name` AS `company_name`,`new_view_stickerdata`.`original_order` AS `original_order` from `new_view_stickerdata` group by `new_view_stickerdata`.`controlsheet_id`) `sti` on((`sti`.`controlsheet_id` = `cs`.`id`))) join (select `bt_production_schedules`.`controlsheet_id` AS `controlsheet_id`,`bt_production_schedules`.`total_units_passed_qc` AS `total_units_passed_qc`,`bt_production_schedules`.`total_units_produced` AS `total_units_produced`,`bt_production_schedules`.`weight_scrap_kg` AS `weight_scrap_kg`,`bt_production_schedules`.`over_weight_kg` AS `over_weight_kg`,`bt_production_schedules`.`total_kg_processed` AS `total_kg_processed`,((`bt_production_schedules`.`weight_scrap_kg` / `bt_production_schedules`.`total_kg_processed`) * 100) AS `scrap_perc`,`scrapdata`.`list_of_codes` AS `list_of_codes` from (`bt_production_schedules` left join (select `bt_prod_scrap_shedule`.`schedule_id` AS `schedule_id`,group_concat(`scode`.`reason`,', ' separator ',') AS `list_of_codes` from (`bt_prod_scrap_shedule` join `bt_production_scrap_codes` `scode` on((`scode`.`id` = `bt_prod_scrap_shedule`.`scrapcode_id`))) group by `bt_prod_scrap_shedule`.`schedule_id`) `scrapdata` on((`scrapdata`.`schedule_id` = `bt_production_schedules`.`id`))) where ((`bt_production_schedules`.`controlsheet_id` > 0) and (((`bt_production_schedules`.`weight_scrap_kg` / `bt_production_schedules`.`total_kg_processed`) * 100) >= 10))) `schdata` on((`schdata`.`controlsheet_id` = `cs`.`id`))) left join `bt_production_production_plan_items` `plani` on((`plani`.`id` = `cs`.`planitem_id`))) order by `cs`.`id` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_quote_po_invoiced_by_salesrep`
--

/*!50001 DROP VIEW IF EXISTS `view_quote_po_invoiced_by_salesrep`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`admin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `view_quote_po_invoiced_by_salesrep` AS select cast(`q`.`created_at` as date) AS `quote_date`,`q`.`id` AS `quote_id`,concat(`users`.`name`,' ',`users`.`surname`) AS `sales_person`,`q`.`company_name` AS `company_name`,`q`.`ponumber` AS `ponumber`,`q`.`totalincvat` AS `totalincvat`,`inv`.`invoiced_amount` AS `invoiced_amount` from ((`bt_sales_newquote` `q` join `users` on((`users`.`id` = `q`.`user_id`))) left join (select `bt_sales_invoices`.`quote_id` AS `quote_id`,sum(`bt_sales_invoices`.`amount`) AS `invoiced_amount` from `bt_sales_invoices` group by `bt_sales_invoices`.`quote_id`) `inv` on((`inv`.`quote_id` = `q`.`id`))) where ((`q`.`ponumber` is not null) and (`q`.`ponumber` <> '') and (cast(`q`.`created_at` as date) >= cast('2023-01-01' as date))) order by `q`.`id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_srn_units_vs_sticker_units`
--

/*!50001 DROP VIEW IF EXISTS `view_srn_units_vs_sticker_units`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`admin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `view_srn_units_vs_sticker_units` AS select `srn`.`id` AS `id`,`srn`.`pickslip_id` AS `pickslip_id`,`srn`.`schedule_date` AS `schedule_date`,`srn`.`quote_id` AS `quote_id`,`q`.`company_name` AS `company_name`,`srn_i`.`srn_sum_unit` AS `srn_sum_unit`,`stidata`.`count_sicker` AS `count_sicker`,`catalogues_sum`.`srn_sum_unit` AS `catalogues_sum_unit`,concat(`buser`.`first_name`,' ',`buser`.`last_name`) AS `srn_created_by`,`srn`.`created_at` AS `created_at` from (((((`bt_sales_srns` `srn` left join `bt_sales_newquote` `q` on((`q`.`id` = `srn`.`quote_id`))) left join (select `srn_i`.`srn_id` AS `srn_id`,sum(`srn_i`.`units`) AS `srn_sum_unit` from `bt_sales_srn_items` `srn_i` where (`srn_i`.`created_at` > '2023-08-01') group by `srn_i`.`srn_id`) `srn_i` on((`srn_i`.`srn_id` = `srn`.`id`))) left join (select `stidata`.`srn_id` AS `srn_id`,count(`stidata`.`srn_id`) AS `count_sicker` from `bt_production_pipestickeritems` `stidata` where (`stidata`.`srn_id` > 0) group by `stidata`.`srn_id`) `stidata` on((`stidata`.`srn_id` = `srn`.`id`))) left join (select `catalogues`.`srn_id` AS `srn_id`,sum(`catalogues`.`units`) AS `srn_sum_unit` from `bt_sales_srn_catalogues` `catalogues` where (`catalogues`.`created_at` > '2023-08-01') group by `catalogues`.`srn_id`) `catalogues_sum` on((`catalogues_sum`.`srn_id` = `srn`.`id`))) left join `backend_users` `buser` on((`buser`.`id` = `srn`.`created_by`))) where (`srn`.`created_at` > '2023-09-01') order by `srn`.`created_at` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_ControlSheetMassData`
--

/*!50001 DROP VIEW IF EXISTS `view_ControlSheetMassData`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`admin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `view_ControlSheetMassData` AS select `cs`.`id` AS `id`,concat(`cs`.`jobcard_id`,', #',`cs`.`jobcard_id`,'-',`cs`.`batch_id`) AS `csname`,concat(`cs`.`jobcard_id`,'-',`cs`.`batch_id`) AS `batch_no`,`cs`.`created_at` AS `cs_created_date`,`cs`.`opendate` AS `cs_run_date`,`qi`.`quote_id` AS `quote_id`,`qi`.`description` AS `description`,`qi`.`units` AS `ordered_units`,`qi`.`priceperkg` AS `ordered_priceperkg`,`qi`.`unitlength` AS `ordered_unitlength`,`qi`.`weight` AS `ordered_unitweight`,`qi`.`totalweight` AS `ordered_totalweight`,`cs`.`plan_id` AS `plan_id`,`cs`.`total_weight` AS `cs_total_weight`,`sti`.`shift` AS `shift`,`sti`.`baila` AS `baila`,`sti`.`company_name` AS `company_name`,`sti`.`original_order` AS `original_order`,`plani`.`qty` AS `plan_target_qty`,`sti`.`count_sticker` AS `count_sticker`,`schdata`.`total_units_passed_qc` AS `lebo_total_units_passed_qc`,`schdata`.`total_units_produced` AS `lebo_total_units_produced`,`schdata`.`weight_scrap_kg` AS `lebo_weight_scrap_kg`,`schdata`.`over_weight_kg` AS `lebo_over_weight_kg` from ((((((`bt_production_control_sheets` `cs` join `bt_production_jobcards` `jc` on((`jc`.`id` = `cs`.`jobcard_id`))) join `bt_production_pipes` `p` on((`p`.`id` = `jc`.`pipe_id`))) join `bt_sales_quoteitems` `qi` on((`qi`.`id` = `p`.`quoteitem_id`))) left join (select `new_view_stickerdata`.`controlsheet_id` AS `controlsheet_id`,count(`new_view_stickerdata`.`controlsheet_id`) AS `count_sticker`,`new_view_stickerdata`.`shift` AS `shift`,`new_view_stickerdata`.`Baila` AS `baila`,`new_view_stickerdata`.`company_name` AS `company_name`,`new_view_stickerdata`.`original_order` AS `original_order` from `new_view_stickerdata` group by `new_view_stickerdata`.`controlsheet_id`) `sti` on((`sti`.`controlsheet_id` = `cs`.`id`))) left join (select `bt_production_schedules`.`controlsheet_id` AS `controlsheet_id`,`bt_production_schedules`.`total_units_passed_qc` AS `total_units_passed_qc`,`bt_production_schedules`.`total_units_produced` AS `total_units_produced`,`bt_production_schedules`.`weight_scrap_kg` AS `weight_scrap_kg`,`bt_production_schedules`.`over_weight_kg` AS `over_weight_kg` from `bt_production_schedules` where (`bt_production_schedules`.`controlsheet_id` > 0)) `schdata` on((`schdata`.`controlsheet_id` = `cs`.`id`))) left join `bt_production_production_plan_items` `plani` on((`plani`.`id` = `cs`.`planitem_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `report_v_weekly_production`
--

/*!50001 DROP VIEW IF EXISTS `report_v_weekly_production`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`admin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `report_v_weekly_production` AS select year(`bt_production_schedules`.`production_date`) AS `Year`,monthname(`bt_production_schedules`.`production_date`) AS `Month`,week((`bt_production_schedules`.`production_date` - interval 1 day),0) AS `Week`,sum(`bt_production_schedules`.`total_kg_processed`) AS `total_kg_processed`,sum(`bt_production_schedules`.`weight_scrap_kg`) AS `weight_scrap_kg`,sum(`bt_production_schedules`.`over_weight_kg`) AS `over_weight_kg`,(sum(`bt_production_schedules`.`weight_scrap_kg`) + sum(`bt_production_schedules`.`over_weight_kg`)) AS `Total Waste` from `bt_production_schedules` where (`bt_production_schedules`.`production_date` > '2022-01-01 00:00:01') group by month(`bt_production_schedules`.`production_date`),year(`bt_production_schedules`.`production_date`),week((`bt_production_schedules`.`production_date` - interval 1 day),0) order by `bt_production_schedules`.`production_date` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_quote_invoice`
--

/*!50001 DROP VIEW IF EXISTS `view_quote_invoice`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`admin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `view_quote_invoice` AS select `q`.`id` AS `id`,`q`.`user_id` AS `user_id`,concat(`users`.`name`,' ',`users`.`surname`) AS `sales_person`,`q`.`company_name` AS `company_name`,`q`.`ponumber` AS `ponumber`,`q`.`created_at` AS `quote_date`,`q`.`total` AS `quote_total_value`,`q`.`totalincvat` AS `quote_total_value_incvat`,`inv`.`invoice_date` AS `invoice_date`,coalesce(`inv`.`total_invoiced`,0) AS `total_invoiced`,`inv`.`count_invoiced` AS `count_invoiced` from ((`bt_sales_newquote` `q` join `users` on((`users`.`id` = `q`.`user_id`))) left join (select `inv`.`quote_id` AS `quote_id`,`inv`.`invoice_date` AS `invoice_date`,sum(`inv`.`amount`) AS `total_invoiced`,count(`inv`.`quote_id`) AS `count_invoiced` from `bt_sales_invoices` `inv` group by `inv`.`quote_id`) `inv` on((`inv`.`quote_id` = `q`.`id`))) where ((`q`.`ponumber` is not null) and (`q`.`ponumber` <> '')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_quote_perfomance`
--

/*!50001 DROP VIEW IF EXISTS `view_quote_perfomance`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`admin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `view_quote_perfomance` AS select `cs`.`id` AS `id`,`p`.`push_id` AS `push_id`,`schdata`.`id` AS `sc_id`,concat(convert(dayname(`cs`.`opendate`) using utf8mb4),', ',convert(lpad(dayofmonth(`cs`.`opendate`),2,'0') using utf8mb4),' ',convert(monthname(`cs`.`opendate`) using utf8mb4),' ',year(`cs`.`opendate`)) AS `cs_run_date_long`,`q`.`company_name` AS `client`,`cs`.`shift` AS `shift`,`line`.`name` AS `baila`,coalesce(`qi`.`quote_id`,0) AS `quote_id`,`qi`.`description` AS `description`,`rat`.`name` AS `class`,`dia`.`name` AS `diameter`,`qi`.`units` AS `ordered_units`,`qi`.`unitlength` AS `ordered_unitlength`,`qi`.`weight` AS `ordered_unitweight`,`qi`.`unitproductionweight` AS `unitproductionweight`,`qi`.`totalweight` AS `ordered_totalweight`,`qi`.`totalproductionweight` AS `totalproductionweight`,`qi`.`price` AS `ordered_totalcost`,(`qi`.`totalweight` * `schdata`.`raw_material_cost`) AS `assigned_cost_zar`,`schdata`.`purge_cost` AS `purge_cost`,`qi`.`totalweight` AS `5_p_scrap_ls_spillage_weight`,(`qi`.`totalweight` * `schdata`.`raw_material_cost`) AS `5_scrap_ls_spillage_cost`,`qi`.`price` AS `sales_purchase_order_value_zar`,`qi`.`priceperkg` AS `ordered_priceperkg`,`schdata`.`raw_material_cost` AS `raw_mix_cost`,`schdata`.`total_units_produced` AS `total_units_produced`,(`qi`.`price` - ((`qi`.`totalweight` * `schdata`.`raw_material_cost`) - `schdata`.`raw_material_cost`)) AS `planned_pre_pargins_zar`,(((`qi`.`price` - ((`qi`.`totalweight` * `schdata`.`raw_material_cost`) - `schdata`.`raw_material_cost`)) / `qi`.`price`) * 100) AS `planned_pre_margins`,`cs`.`mass` AS `kgm_production`,`cs`.`standardweight` AS `pipe_weight_per_length_target`,`schdata`.`total_kg_processed` AS `production_total_weight`,(`schdata`.`total_kg_processed` * `schdata`.`raw_material_cost`) AS `assigned_cost`,(`schdata`.`total_kg_processed` * `qi`.`priceperkg`) AS `actual_production_cost`,((`schdata`.`total_kg_processed` * `qi`.`priceperkg`) - (0 + (`schdata`.`total_kg_processed` * `schdata`.`raw_material_cost`))) AS `actual_margins_zar`,`schdata`.`purge_cost` AS `purge_cost_zar`,`schdata`.`weight_scrap_kg` AS `weight_scrap_kg`,`schdata`.`lab_sample_weight` AS `lab_sample_weight_kg`,`schdata`.`overrun_weight` AS `overrun_weight`,`schdata`.`purge_weight` AS `purge_weight`,((`schdata`.`lab_sample_weight` + `schdata`.`weight_scrap_kg`) * `schdata`.`raw_material_cost`) AS `scrap_cost_zar`,concat(`cs`.`jobcard_id`,', #',`cs`.`jobcard_id`,'-',`cs`.`batch_id`) AS `csname`,concat(`cs`.`jobcard_id`,'-',`cs`.`batch_id`) AS `batch_no`,`cs`.`created_at` AS `cs_created_date`,`cs`.`opendate` AS `cs_run_date`,`cs`.`plan_id` AS `plan_id`,`cs`.`total_weight` AS `cs_total_weight`,`sti`.`company_name` AS `company_name`,`sti`.`original_order` AS `original_order`,`plani`.`qty` AS `plan_target_qty`,`sti`.`count_sticker` AS `count_sticker`,`schdata`.`total_units_passed_qc` AS `lebo_total_units_passed_qc`,`schdata`.`over_weight_kg` AS `lebo_over_weight_kg` from (((((((((((`bt_production_control_sheets` `cs` join `bt_production_jobcards` `jc` on((`jc`.`id` = `cs`.`jobcard_id`))) join `bt_production_pipes` `p` on((`p`.`id` = `jc`.`pipe_id`))) join `bt_sales_quoteitems` `qi` on((`qi`.`id` = `p`.`quoteitem_id`))) join `bt_production_lines` `line` on((`line`.`id` = `cs`.`line_id`))) join `bt_sales_newquote` `q` on((`q`.`id` = `qi`.`quote_id`))) join `bt_sales_products` `prod` on((`prod`.`id` = `qi`.`product_id`))) join `bt_sales_diameters` `dia` on((`dia`.`id` = `prod`.`diameter_id`))) join `bt_sales_p_n_ratings` `rat` on((`rat`.`id` = `prod`.`pn_ratings_id`))) left join (select `new_view_stickerdata`.`controlsheet_id` AS `controlsheet_id`,count(`new_view_stickerdata`.`controlsheet_id`) AS `count_sticker`,`new_view_stickerdata`.`shift` AS `shift`,`new_view_stickerdata`.`Baila` AS `baila`,`new_view_stickerdata`.`company_name` AS `company_name`,`new_view_stickerdata`.`original_order` AS `original_order` from `new_view_stickerdata` group by `new_view_stickerdata`.`controlsheet_id`) `sti` on((`sti`.`controlsheet_id` = `cs`.`id`))) left join (select `bt_production_schedules`.`id` AS `id`,`bt_production_schedules`.`controlsheet_id` AS `controlsheet_id`,`bt_production_schedules`.`total_units_passed_qc` AS `total_units_passed_qc`,`bt_production_schedules`.`total_units_produced` AS `total_units_produced`,`bt_production_schedules`.`weight_scrap_kg` AS `weight_scrap_kg`,`bt_production_schedules`.`over_weight_kg` AS `over_weight_kg`,`bt_production_schedules`.`total_kg_processed` AS `total_kg_processed`,`bt_production_schedules`.`raw_material_cost` AS `raw_material_cost`,`bt_production_schedules`.`lab_sample_weight` AS `lab_sample_weight`,`bt_production_schedules`.`overrun_weight` AS `overrun_weight`,`bt_production_schedules`.`purge_weight` AS `purge_weight`,`bt_production_schedules`.`purge_cost` AS `purge_cost` from `bt_production_schedules` where (`bt_production_schedules`.`controlsheet_id` > 0)) `schdata` on((`schdata`.`controlsheet_id` = `cs`.`id`))) left join `bt_production_production_plan_items` `plani` on((`plani`.`id` = `cs`.`planitem_id`))) order by `cs`.`id` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_QuoteReponse_po`
--

/*!50001 DROP VIEW IF EXISTS `view_QuoteReponse_po`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`admin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `view_QuoteReponse_po` AS select `qre`.`quote_id` AS `quote_id`,`q`.`ponumber` AS `ponumber`,`qre`.`poamount` AS `poamount`,`q`.`totalincvat` AS `totalincvat`,`q`.`billing_name` AS `billing_name`,`q`.`created_at` AS `created_at`,`f`.`file_name` AS `file_name`,concat('https://bailaerp.bt-industrial.co.za/storage/app/uploads/public/',substr(`f`.`disk_name`,1,3),'/',substr(`f`.`disk_name`,4,3),'/',substr(`f`.`disk_name`,7,3),'/',`f`.`disk_name`) AS `formatted_column` from ((`bt_sales_quote_reponses` `qre` join `bt_sales_newquote` `q` on((`q`.`id` = `qre`.`quote_id`))) left join `system_files` `f` on((`f`.`attachment_id` = `qre`.`id`))) where ((`qre`.`quote_status_id` = 10) and (`q`.`client_id` = 13) and (`f`.`attachment_type` like '%QuoteReponse%')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_weeky_production_vs_electricity`
--

/*!50001 DROP VIEW IF EXISTS `view_weeky_production_vs_electricity`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`admin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `view_weeky_production_vs_electricity` AS select `pb`.`id` AS `id`,concat('wk ',week(`pb`.`start_date`,0),'-',year(`pb`.`start_date`)) AS `Week`,cast(`pb`.`start_date` as date) AS `start_date`,cast(`pb`.`end_date` as date) AS `end_date`,`btline`.`name` AS `baila_name`,`el`.`total_kg_processed` AS `total_kg_processed`,`el`.`weight_scrap_kg` AS `weight_scrap_kg`,`el`.`over_weight_kg` AS `over_weight_kg`,`pb`.`off_peak_kwh` AS `off_peak_kwh`,`pb`.`off_peak_amount` AS `off_peak_amount`,`pb`.`standard_kwh` AS `standard_kwh`,`pb`.`standard_amount` AS `standard_amount`,`pb`.`on_peak_kwh` AS `on_peak_kwh`,`pb`.`on_peak_amount` AS `on_peak_amount`,`pb`.`max_demand_amount` AS `max_demand_amount`,`pb`.`fixed_charge_amount` AS `fixed_charge_amount`,`pb`.`network_access_amount` AS `network_access_amount`,`pb`.`total_amount` AS `total_amount` from ((`bt_maintenance_provincial_bills` `pb` join `bt_production_lines` `btline` on((`btline`.`id` = `pb`.`line_id`))) left join (select `view_electricity_production`.`week_id` AS `week_id`,`view_electricity_production`.`year_id` AS `year_id`,`view_electricity_production`.`line_id` AS `line_id`,`view_electricity_production`.`baila` AS `baila`,sum(`view_electricity_production`.`total_kg_processed`) AS `total_kg_processed`,sum(`view_electricity_production`.`weight_scrap_kg`) AS `weight_scrap_kg`,sum(`view_electricity_production`.`over_weight_kg`) AS `over_weight_kg` from `view_electricity_production` group by `view_electricity_production`.`week_id`,`view_electricity_production`.`year_id`,`view_electricity_production`.`line_id`) `el` on(((`el`.`week_id` = week(`pb`.`start_date`,0)) and (`el`.`year_id` = year(`pb`.`start_date`)) and (`el`.`line_id` = `pb`.`line_id`)))) order by cast(`pb`.`start_date` as date),`btline`.`name` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-05 18:01:53
