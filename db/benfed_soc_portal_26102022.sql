-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 26, 2022 at 06:17 PM
-- Server version: 5.7.40-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `benfed_soc_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `td_users`
--

CREATE TABLE `td_users` (
  `id` int(10) NOT NULL,
  `pan` varchar(20) NOT NULL,
  `email` varchar(55) NOT NULL,
  `password` varchar(100) NOT NULL,
  `soc_id` int(10) NOT NULL,
  `soc_name` varchar(255) DEFAULT NULL,
  `soc_address` text,
  `gstin` varchar(150) DEFAULT NULL,
  `mfms` varchar(150) DEFAULT NULL,
  `ph_number` varchar(30) DEFAULT NULL,
  `registration_status` enum('1','2') NOT NULL,
  `status` enum('1','0') DEFAULT '0',
  `created_by` varchar(55) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` varchar(55) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `td_users`
--

INSERT INTO `td_users` (`id`, `pan`, `email`, `password`, `soc_id`, `soc_name`, `soc_address`, `gstin`, `mfms`, `ph_number`, `registration_status`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'ABCD123', 'abc@gmail.com', '$2y$10$.6VnzwVhon2zOsjihjZtLuB0D1SiQ78Cu8J3AQGrrNRU5UZ0sxkra', 123, 'test society', 'kolkata dddd', '4525635', 'hhthhshh', '8956898956', '2', '1', 'abc@gmail.com', '2022-10-25 06:57:10', 'abc@gmail.com', '2022-10-25 01:27:37');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_advance`
-- (See below for the actual view)
--
CREATE TABLE `v_advance` (
`trans_dt` date
,`sl_no` int(11)
,`receipt_no` varchar(50)
,`fin_yr` int(11)
,`branch_id` int(11)
,`soc_id` int(11)
,`cshbnk_flag` enum('0','1')
,`trans_type` enum('I','O')
,`adv_amt` decimal(10,0)
,`inv_no` varchar(50)
,`ro_no` varchar(30)
,`bank` int(11)
,`remarks` text
,`referenceNo` varchar(50)
,`forward_flag` enum('Y','N')
,`comp_pmt_flag` enum('Y','N')
,`comp_adv_flag` enum('Y','N')
,`paid_id` varchar(50)
,`created_by` varchar(50)
,`created_dt` datetime
,`modifed_by` varchar(50)
,`modifed_dt` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_adv_details`
-- (See below for the actual view)
--
CREATE TABLE `v_adv_details` (
`id` int(11)
,`trans_dt` date
,`receipt_no` varchar(100)
,`detail_receipt_no` varchar(100)
,`comp_id` int(11)
,`prod_id` int(11)
,`fo_no` bigint(20)
,`ro_no` varchar(100)
,`qty` decimal(10,3)
,`rate` decimal(10,2)
,`amount` decimal(10,2)
,`branch_id` int(11)
,`status` enum('N','Y')
,`comp_pay_flag` enum('Y','N')
,`fin_yr` int(11)
,`created_by` varchar(55)
,`created_dt` datetime
,`modified_by` varchar(55)
,`modified_dt` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_cr_note_category`
-- (See below for the actual view)
--
CREATE TABLE `v_cr_note_category` (
`sl_no` int(11)
,`cat_desc` varchar(50)
,`acc_cd` int(11)
,`created_by` varchar(50)
,`created_dt` datetime
,`modified_by` varchar(50)
,`modified_dt` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_dr_cr_note`
-- (See below for the actual view)
--
CREATE TABLE `v_dr_cr_note` (
`trans_dt` date
,`trans_no` int(11)
,`recpt_no` varchar(100)
,`soc_id` int(11)
,`comp_id` int(11)
,`invoice_no` varchar(50)
,`ro` varchar(30)
,`catg` int(11)
,`tot_amt` decimal(10,2)
,`trans_flag` enum('R','A')
,`note_type` enum('D','C')
,`fwd_flag` enum('Y','N')
,`br_adj_flag` enum('Y','N')
,`comp_adjflag` enum('Y','N')
,`branch_id` int(11)
,`fin_yr` int(11)
,`remarks` text
,`created_by` varchar(30)
,`created_dt` datetime
,`modified_by` varchar(20)
,`modified_dt` datetime
,`adjusted_by` varchar(50)
,`adjusted_dt` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_feri_bank`
-- (See below for the actual view)
--
CREATE TABLE `v_feri_bank` (
`sl_no` int(11)
,`dist_cd` int(11)
,`acc_code` varchar(10)
,`bank_name` varchar(100)
,`branch_name` varchar(100)
,`ac_no` varchar(50)
,`ifsc` varchar(25)
,`created_by` varchar(50)
,`created_dt` datetime
,`modified_by` varchar(50)
,`modified_dt` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_ferti_soc`
-- (See below for the actual view)
--
CREATE TABLE `v_ferti_soc` (
`soc_id` int(11)
,`soc_name` varchar(100)
,`soc_add` text
,`district` varchar(20)
,`pin` int(11)
,`ph_no` varchar(20)
,`email` varchar(100)
,`pan` varchar(15)
,`gstin` varchar(20)
,`mfms` varchar(20)
,`status` enum('N','O','R')
,`stock_point_flag` enum('Y','N')
,`buffer_flag` enum('N','B','I')
,`acc_cd` int(11)
,`adv_acc` int(11)
,`created_by` varchar(50)
,`created_dt` datetime
,`modified_by` varchar(50)
,`modified_dt` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_payment_recv`
-- (See below for the actual view)
--
CREATE TABLE `v_payment_recv` (
`sl_no` int(11)
,`paid_id` varchar(50)
,`paid_dt` date
,`soc_id` int(11)
,`sale_invoice_no` varchar(50)
,`sale_invoice_dt` datetime
,`ro_no` varchar(30)
,`pay_type` varchar(10)
,`comp_id` int(11)
,`prod_id` int(11)
,`ro_rt` decimal(20,3)
,`ref_no` varchar(30)
,`ref_dt` date
,`bnk_id` int(11)
,`tot_recvble_amt` decimal(10,2)
,`adj_dr_note_amt` decimal(10,2)
,`adj_adv_amt` decimal(10,2)
,`net_recvble_amt` decimal(10,2)
,`approval_status` enum('U','A')
,`paid_amt` decimal(10,2)
,`paid_qty` decimal(10,3)
,`cshbnk_flag` enum('0','1')
,`branch_id` int(11)
,`fin_yr` int(11)
,`remarks` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_product`
-- (See below for the actual view)
--
CREATE TABLE `v_product` (
`PROD_ID` int(11)
,`PROD_DESC` varchar(100)
,`COMPANY` varchar(30)
,`PROD_TYPE` varchar(30)
,`mat_state` int(11)
,`CREATED_BY` varchar(30)
,`CREATED_DT` datetime
,`MODIFIED_BY` varchar(30)
,`MODIFIED_DT` datetime
,`COMMODITY_ID` varchar(30)
,`GST_RT` decimal(10,2)
,`HSN_CODE` int(11)
,`QTY_PER_BAG` int(11)
,`unit` int(11)
,`storage` enum('B','T','P')
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_purchase`
-- (See below for the actual view)
--
CREATE TABLE `v_purchase` (
`trans_cd` bigint(20)
,`trans_dt` date
,`adv_status` enum('Y','N')
,`trans_flag` enum('1','2')
,`comp_id` int(11)
,`comp_acc_cd` int(11)
,`prod_id` int(11)
,`ro_no` varchar(30)
,`ro_dt` date
,`invoice_no` varchar(30)
,`invoice_dt` date
,`advance_receipt_no` varchar(100)
,`due_dt` date
,`no_of_days` int(11)
,`qty` decimal(20,3)
,`unit` int(11)
,`stock_qty` decimal(10,3)
,`no_of_bags` int(11)
,`delivery_mode` enum('1','2','3','4','5')
,`reck_pt_rt` decimal(10,2)
,`reck_pt_n_rt` decimal(10,2)
,`govt_sale_rt` decimal(10,2)
,`iffco_buf_rt` decimal(10,2)
,`iffco_n_buff_rt` decimal(10,2)
,`challan_flag` varchar(5)
,`rate` decimal(10,2)
,`base_price` decimal(10,2)
,`cgst` decimal(10,2)
,`sgst` decimal(10,2)
,`retlr_margin` decimal(10,2)
,`spl_rebt` decimal(10,2)
,`rbt_add` decimal(10,2)
,`rbt_less` decimal(10,2)
,`rnd_of_add` decimal(10,2)
,`rnd_of_less` decimal(10,2)
,`trad_margin` decimal(20,2)
,`oth_dis` decimal(20,2)
,`frt_subsidy` decimal(20,2)
,`tot_amt` decimal(10,2)
,`net_amt` decimal(10,2)
,`add_adj_amt` decimal(10,2)
,`less_adj_amt` decimal(10,2)
,`add_ret_margin_flag` enum('N','Y')
,`less_spl_rbt_flag` enum('N','Y')
,`add_adj_amt_flag` enum('N','Y')
,`less_adj_amt_flag` enum('N','Y')
,`less_trad_margin_flag` enum('N','Y')
,`less_oth_dis_flag` enum('N','Y')
,`less_frght_subsdy_flag` enum('N','Y')
,`created_by` varchar(30)
,`created_dt` date
,`modified_by` varchar(30)
,`modified_dt` date
,`br` int(11)
,`fin_yr` varchar(20)
,`stock_point` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_sale`
-- (See below for the actual view)
--
CREATE TABLE `v_sale` (
`inv_no` varchar(50)
,`inv_dt` date
,`soc_id` int(11)
,`irn` varchar(500)
,`ack` varchar(200)
,`ack_dt` datetime
,`br_cd` int(11)
,`fin_yr` varchar(10)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_sale_cancel`
-- (See below for the actual view)
--
CREATE TABLE `v_sale_cancel` (
`trans_do` varchar(50)
,`trans_no` int(11)
,`do_dt` date
,`no_of_days` int(11)
,`sale_due_dt` date
,`trans_type` varchar(15)
,`soc_id` int(11)
,`comp_id` int(11)
,`sale_ro` varchar(30)
,`prod_id` int(11)
,`unit` int(11)
,`catg_id` int(11)
,`stock_point` varchar(50)
,`gov_sale_rt` enum('Y','N')
,`qty` decimal(10,3)
,`sale_rt` decimal(10,2)
,`base_price` decimal(10,2)
,`taxable_amt` decimal(10,2)
,`cgst` decimal(10,2)
,`sgst` decimal(10,2)
,`dis` decimal(10,2)
,`tot_amt` decimal(10,2)
,`round_tot_amt` decimal(20,2)
,`paid_amt` decimal(20,2)
,`irn` varchar(500)
,`irn_cnl_reason` enum('1','2','3','4')
,`irn_cnl_rem` varchar(100)
,`ack` varchar(200)
,`ack_dt` datetime
,`gst_type_flag` enum('Y','N')
,`nwirn` varchar(100)
,`cnl_flag` enum('INV','CRN','DBN')
,`created_by` varchar(30)
,`created_dt` date
,`modified_by` varchar(30)
,`modified_dt` date
,`br_cd` int(11)
,`fin_yr` varchar(10)
);

-- --------------------------------------------------------

--
-- Structure for view `v_advance`
--
DROP TABLE IF EXISTS `v_advance`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_advance`  AS  select `benfed_fertilizer`.`tdf_advance`.`trans_dt` AS `trans_dt`,`benfed_fertilizer`.`tdf_advance`.`sl_no` AS `sl_no`,`benfed_fertilizer`.`tdf_advance`.`receipt_no` AS `receipt_no`,`benfed_fertilizer`.`tdf_advance`.`fin_yr` AS `fin_yr`,`benfed_fertilizer`.`tdf_advance`.`branch_id` AS `branch_id`,`benfed_fertilizer`.`tdf_advance`.`soc_id` AS `soc_id`,`benfed_fertilizer`.`tdf_advance`.`cshbnk_flag` AS `cshbnk_flag`,`benfed_fertilizer`.`tdf_advance`.`trans_type` AS `trans_type`,`benfed_fertilizer`.`tdf_advance`.`adv_amt` AS `adv_amt`,`benfed_fertilizer`.`tdf_advance`.`inv_no` AS `inv_no`,`benfed_fertilizer`.`tdf_advance`.`ro_no` AS `ro_no`,`benfed_fertilizer`.`tdf_advance`.`bank` AS `bank`,`benfed_fertilizer`.`tdf_advance`.`remarks` AS `remarks`,`benfed_fertilizer`.`tdf_advance`.`referenceNo` AS `referenceNo`,`benfed_fertilizer`.`tdf_advance`.`forward_flag` AS `forward_flag`,`benfed_fertilizer`.`tdf_advance`.`comp_pmt_flag` AS `comp_pmt_flag`,`benfed_fertilizer`.`tdf_advance`.`comp_adv_flag` AS `comp_adv_flag`,`benfed_fertilizer`.`tdf_advance`.`paid_id` AS `paid_id`,`benfed_fertilizer`.`tdf_advance`.`created_by` AS `created_by`,`benfed_fertilizer`.`tdf_advance`.`created_dt` AS `created_dt`,`benfed_fertilizer`.`tdf_advance`.`modifed_by` AS `modifed_by`,`benfed_fertilizer`.`tdf_advance`.`modifed_dt` AS `modifed_dt` from `benfed_fertilizer`.`tdf_advance` where (`benfed_fertilizer`.`tdf_advance`.`trans_type` = 'I') ;

-- --------------------------------------------------------

--
-- Structure for view `v_adv_details`
--
DROP TABLE IF EXISTS `v_adv_details`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_adv_details`  AS  select `benfed_fertilizer`.`td_adv_details`.`id` AS `id`,`benfed_fertilizer`.`td_adv_details`.`trans_dt` AS `trans_dt`,`benfed_fertilizer`.`td_adv_details`.`receipt_no` AS `receipt_no`,`benfed_fertilizer`.`td_adv_details`.`detail_receipt_no` AS `detail_receipt_no`,`benfed_fertilizer`.`td_adv_details`.`comp_id` AS `comp_id`,`benfed_fertilizer`.`td_adv_details`.`prod_id` AS `prod_id`,`benfed_fertilizer`.`td_adv_details`.`fo_no` AS `fo_no`,`benfed_fertilizer`.`td_adv_details`.`ro_no` AS `ro_no`,`benfed_fertilizer`.`td_adv_details`.`qty` AS `qty`,`benfed_fertilizer`.`td_adv_details`.`rate` AS `rate`,`benfed_fertilizer`.`td_adv_details`.`amount` AS `amount`,`benfed_fertilizer`.`td_adv_details`.`branch_id` AS `branch_id`,`benfed_fertilizer`.`td_adv_details`.`status` AS `status`,`benfed_fertilizer`.`td_adv_details`.`comp_pay_flag` AS `comp_pay_flag`,`benfed_fertilizer`.`td_adv_details`.`fin_yr` AS `fin_yr`,`benfed_fertilizer`.`td_adv_details`.`created_by` AS `created_by`,`benfed_fertilizer`.`td_adv_details`.`created_dt` AS `created_dt`,`benfed_fertilizer`.`td_adv_details`.`modified_by` AS `modified_by`,`benfed_fertilizer`.`td_adv_details`.`modified_dt` AS `modified_dt` from `benfed_fertilizer`.`td_adv_details` ;

-- --------------------------------------------------------

--
-- Structure for view `v_cr_note_category`
--
DROP TABLE IF EXISTS `v_cr_note_category`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_cr_note_category`  AS  select `benfed_fertilizer`.`mm_cr_note_category`.`sl_no` AS `sl_no`,`benfed_fertilizer`.`mm_cr_note_category`.`cat_desc` AS `cat_desc`,`benfed_fertilizer`.`mm_cr_note_category`.`acc_cd` AS `acc_cd`,`benfed_fertilizer`.`mm_cr_note_category`.`created_by` AS `created_by`,`benfed_fertilizer`.`mm_cr_note_category`.`created_dt` AS `created_dt`,`benfed_fertilizer`.`mm_cr_note_category`.`modified_by` AS `modified_by`,`benfed_fertilizer`.`mm_cr_note_category`.`modified_dt` AS `modified_dt` from `benfed_fertilizer`.`mm_cr_note_category` ;

-- --------------------------------------------------------

--
-- Structure for view `v_dr_cr_note`
--
DROP TABLE IF EXISTS `v_dr_cr_note`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_dr_cr_note`  AS  select `benfed_fertilizer`.`tdf_dr_cr_note`.`trans_dt` AS `trans_dt`,`benfed_fertilizer`.`tdf_dr_cr_note`.`trans_no` AS `trans_no`,`benfed_fertilizer`.`tdf_dr_cr_note`.`recpt_no` AS `recpt_no`,`benfed_fertilizer`.`tdf_dr_cr_note`.`soc_id` AS `soc_id`,`benfed_fertilizer`.`tdf_dr_cr_note`.`comp_id` AS `comp_id`,`benfed_fertilizer`.`tdf_dr_cr_note`.`invoice_no` AS `invoice_no`,`benfed_fertilizer`.`tdf_dr_cr_note`.`ro` AS `ro`,`benfed_fertilizer`.`tdf_dr_cr_note`.`catg` AS `catg`,`benfed_fertilizer`.`tdf_dr_cr_note`.`tot_amt` AS `tot_amt`,`benfed_fertilizer`.`tdf_dr_cr_note`.`trans_flag` AS `trans_flag`,`benfed_fertilizer`.`tdf_dr_cr_note`.`note_type` AS `note_type`,`benfed_fertilizer`.`tdf_dr_cr_note`.`fwd_flag` AS `fwd_flag`,`benfed_fertilizer`.`tdf_dr_cr_note`.`br_adj_flag` AS `br_adj_flag`,`benfed_fertilizer`.`tdf_dr_cr_note`.`comp_adjflag` AS `comp_adjflag`,`benfed_fertilizer`.`tdf_dr_cr_note`.`branch_id` AS `branch_id`,`benfed_fertilizer`.`tdf_dr_cr_note`.`fin_yr` AS `fin_yr`,`benfed_fertilizer`.`tdf_dr_cr_note`.`remarks` AS `remarks`,`benfed_fertilizer`.`tdf_dr_cr_note`.`created_by` AS `created_by`,`benfed_fertilizer`.`tdf_dr_cr_note`.`created_dt` AS `created_dt`,`benfed_fertilizer`.`tdf_dr_cr_note`.`modified_by` AS `modified_by`,`benfed_fertilizer`.`tdf_dr_cr_note`.`modified_dt` AS `modified_dt`,`benfed_fertilizer`.`tdf_dr_cr_note`.`adjusted_by` AS `adjusted_by`,`benfed_fertilizer`.`tdf_dr_cr_note`.`adjusted_dt` AS `adjusted_dt` from `benfed_fertilizer`.`tdf_dr_cr_note` where ((`benfed_fertilizer`.`tdf_dr_cr_note`.`trans_flag` = 'R') and (`benfed_fertilizer`.`tdf_dr_cr_note`.`recpt_no` like '%Crnote%')) ;

-- --------------------------------------------------------

--
-- Structure for view `v_feri_bank`
--
DROP TABLE IF EXISTS `v_feri_bank`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_feri_bank`  AS  select `benfed_fertilizer`.`mm_feri_bank`.`sl_no` AS `sl_no`,`benfed_fertilizer`.`mm_feri_bank`.`dist_cd` AS `dist_cd`,`benfed_fertilizer`.`mm_feri_bank`.`acc_code` AS `acc_code`,`benfed_fertilizer`.`mm_feri_bank`.`bank_name` AS `bank_name`,`benfed_fertilizer`.`mm_feri_bank`.`branch_name` AS `branch_name`,`benfed_fertilizer`.`mm_feri_bank`.`ac_no` AS `ac_no`,`benfed_fertilizer`.`mm_feri_bank`.`ifsc` AS `ifsc`,`benfed_fertilizer`.`mm_feri_bank`.`created_by` AS `created_by`,`benfed_fertilizer`.`mm_feri_bank`.`created_dt` AS `created_dt`,`benfed_fertilizer`.`mm_feri_bank`.`modified_by` AS `modified_by`,`benfed_fertilizer`.`mm_feri_bank`.`modified_dt` AS `modified_dt` from `benfed_fertilizer`.`mm_feri_bank` ;

-- --------------------------------------------------------

--
-- Structure for view `v_ferti_soc`
--
DROP TABLE IF EXISTS `v_ferti_soc`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ferti_soc`  AS  select `benfed_fertilizer`.`mm_ferti_soc`.`soc_id` AS `soc_id`,`benfed_fertilizer`.`mm_ferti_soc`.`soc_name` AS `soc_name`,`benfed_fertilizer`.`mm_ferti_soc`.`soc_add` AS `soc_add`,`benfed_fertilizer`.`mm_ferti_soc`.`district` AS `district`,`benfed_fertilizer`.`mm_ferti_soc`.`pin` AS `pin`,`benfed_fertilizer`.`mm_ferti_soc`.`ph_no` AS `ph_no`,`benfed_fertilizer`.`mm_ferti_soc`.`email` AS `email`,`benfed_fertilizer`.`mm_ferti_soc`.`pan` AS `pan`,`benfed_fertilizer`.`mm_ferti_soc`.`gstin` AS `gstin`,`benfed_fertilizer`.`mm_ferti_soc`.`mfms` AS `mfms`,`benfed_fertilizer`.`mm_ferti_soc`.`status` AS `status`,`benfed_fertilizer`.`mm_ferti_soc`.`stock_point_flag` AS `stock_point_flag`,`benfed_fertilizer`.`mm_ferti_soc`.`buffer_flag` AS `buffer_flag`,`benfed_fertilizer`.`mm_ferti_soc`.`acc_cd` AS `acc_cd`,`benfed_fertilizer`.`mm_ferti_soc`.`adv_acc` AS `adv_acc`,`benfed_fertilizer`.`mm_ferti_soc`.`created_by` AS `created_by`,`benfed_fertilizer`.`mm_ferti_soc`.`created_dt` AS `created_dt`,`benfed_fertilizer`.`mm_ferti_soc`.`modified_by` AS `modified_by`,`benfed_fertilizer`.`mm_ferti_soc`.`modified_dt` AS `modified_dt` from `benfed_fertilizer`.`mm_ferti_soc` ;

-- --------------------------------------------------------

--
-- Structure for view `v_payment_recv`
--
DROP TABLE IF EXISTS `v_payment_recv`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_payment_recv`  AS  select `benfed_fertilizer`.`tdf_payment_recv`.`sl_no` AS `sl_no`,`benfed_fertilizer`.`tdf_payment_recv`.`paid_id` AS `paid_id`,`benfed_fertilizer`.`tdf_payment_recv`.`paid_dt` AS `paid_dt`,`benfed_fertilizer`.`tdf_payment_recv`.`soc_id` AS `soc_id`,`benfed_fertilizer`.`tdf_payment_recv`.`sale_invoice_no` AS `sale_invoice_no`,`benfed_fertilizer`.`tdf_payment_recv`.`sale_invoice_dt` AS `sale_invoice_dt`,`benfed_fertilizer`.`tdf_payment_recv`.`ro_no` AS `ro_no`,`benfed_fertilizer`.`tdf_payment_recv`.`pay_type` AS `pay_type`,`benfed_fertilizer`.`tdf_payment_recv`.`comp_id` AS `comp_id`,`benfed_fertilizer`.`tdf_payment_recv`.`prod_id` AS `prod_id`,`benfed_fertilizer`.`tdf_payment_recv`.`ro_rt` AS `ro_rt`,`benfed_fertilizer`.`tdf_payment_recv`.`ref_no` AS `ref_no`,`benfed_fertilizer`.`tdf_payment_recv`.`ref_dt` AS `ref_dt`,`benfed_fertilizer`.`tdf_payment_recv`.`bnk_id` AS `bnk_id`,`benfed_fertilizer`.`tdf_payment_recv`.`tot_recvble_amt` AS `tot_recvble_amt`,`benfed_fertilizer`.`tdf_payment_recv`.`adj_dr_note_amt` AS `adj_dr_note_amt`,`benfed_fertilizer`.`tdf_payment_recv`.`adj_adv_amt` AS `adj_adv_amt`,`benfed_fertilizer`.`tdf_payment_recv`.`net_recvble_amt` AS `net_recvble_amt`,`benfed_fertilizer`.`tdf_payment_recv`.`approval_status` AS `approval_status`,`benfed_fertilizer`.`tdf_payment_recv`.`paid_amt` AS `paid_amt`,`benfed_fertilizer`.`tdf_payment_recv`.`paid_qty` AS `paid_qty`,`benfed_fertilizer`.`tdf_payment_recv`.`cshbnk_flag` AS `cshbnk_flag`,`benfed_fertilizer`.`tdf_payment_recv`.`branch_id` AS `branch_id`,`benfed_fertilizer`.`tdf_payment_recv`.`fin_yr` AS `fin_yr`,`benfed_fertilizer`.`tdf_payment_recv`.`remarks` AS `remarks` from `benfed_fertilizer`.`tdf_payment_recv` where (`benfed_fertilizer`.`tdf_payment_recv`.`pay_type` in (3,4,5,7)) ;

-- --------------------------------------------------------

--
-- Structure for view `v_product`
--
DROP TABLE IF EXISTS `v_product`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_product`  AS  select `benfed_fertilizer`.`mm_product`.`PROD_ID` AS `PROD_ID`,`benfed_fertilizer`.`mm_product`.`PROD_DESC` AS `PROD_DESC`,`benfed_fertilizer`.`mm_product`.`COMPANY` AS `COMPANY`,`benfed_fertilizer`.`mm_product`.`PROD_TYPE` AS `PROD_TYPE`,`benfed_fertilizer`.`mm_product`.`mat_state` AS `mat_state`,`benfed_fertilizer`.`mm_product`.`CREATED_BY` AS `CREATED_BY`,`benfed_fertilizer`.`mm_product`.`CREATED_DT` AS `CREATED_DT`,`benfed_fertilizer`.`mm_product`.`MODIFIED_BY` AS `MODIFIED_BY`,`benfed_fertilizer`.`mm_product`.`MODIFIED_DT` AS `MODIFIED_DT`,`benfed_fertilizer`.`mm_product`.`COMMODITY_ID` AS `COMMODITY_ID`,`benfed_fertilizer`.`mm_product`.`GST_RT` AS `GST_RT`,`benfed_fertilizer`.`mm_product`.`HSN_CODE` AS `HSN_CODE`,`benfed_fertilizer`.`mm_product`.`QTY_PER_BAG` AS `QTY_PER_BAG`,`benfed_fertilizer`.`mm_product`.`unit` AS `unit`,`benfed_fertilizer`.`mm_product`.`storage` AS `storage` from `benfed_fertilizer`.`mm_product` ;

-- --------------------------------------------------------

--
-- Structure for view `v_purchase`
--
DROP TABLE IF EXISTS `v_purchase`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_purchase`  AS  select `benfed_fertilizer`.`td_purchase`.`trans_cd` AS `trans_cd`,`benfed_fertilizer`.`td_purchase`.`trans_dt` AS `trans_dt`,`benfed_fertilizer`.`td_purchase`.`adv_status` AS `adv_status`,`benfed_fertilizer`.`td_purchase`.`trans_flag` AS `trans_flag`,`benfed_fertilizer`.`td_purchase`.`comp_id` AS `comp_id`,`benfed_fertilizer`.`td_purchase`.`comp_acc_cd` AS `comp_acc_cd`,`benfed_fertilizer`.`td_purchase`.`prod_id` AS `prod_id`,`benfed_fertilizer`.`td_purchase`.`ro_no` AS `ro_no`,`benfed_fertilizer`.`td_purchase`.`ro_dt` AS `ro_dt`,`benfed_fertilizer`.`td_purchase`.`invoice_no` AS `invoice_no`,`benfed_fertilizer`.`td_purchase`.`invoice_dt` AS `invoice_dt`,`benfed_fertilizer`.`td_purchase`.`advance_receipt_no` AS `advance_receipt_no`,`benfed_fertilizer`.`td_purchase`.`due_dt` AS `due_dt`,`benfed_fertilizer`.`td_purchase`.`no_of_days` AS `no_of_days`,`benfed_fertilizer`.`td_purchase`.`qty` AS `qty`,`benfed_fertilizer`.`td_purchase`.`unit` AS `unit`,`benfed_fertilizer`.`td_purchase`.`stock_qty` AS `stock_qty`,`benfed_fertilizer`.`td_purchase`.`no_of_bags` AS `no_of_bags`,`benfed_fertilizer`.`td_purchase`.`delivery_mode` AS `delivery_mode`,`benfed_fertilizer`.`td_purchase`.`reck_pt_rt` AS `reck_pt_rt`,`benfed_fertilizer`.`td_purchase`.`reck_pt_n_rt` AS `reck_pt_n_rt`,`benfed_fertilizer`.`td_purchase`.`govt_sale_rt` AS `govt_sale_rt`,`benfed_fertilizer`.`td_purchase`.`iffco_buf_rt` AS `iffco_buf_rt`,`benfed_fertilizer`.`td_purchase`.`iffco_n_buff_rt` AS `iffco_n_buff_rt`,`benfed_fertilizer`.`td_purchase`.`challan_flag` AS `challan_flag`,`benfed_fertilizer`.`td_purchase`.`rate` AS `rate`,`benfed_fertilizer`.`td_purchase`.`base_price` AS `base_price`,`benfed_fertilizer`.`td_purchase`.`cgst` AS `cgst`,`benfed_fertilizer`.`td_purchase`.`sgst` AS `sgst`,`benfed_fertilizer`.`td_purchase`.`retlr_margin` AS `retlr_margin`,`benfed_fertilizer`.`td_purchase`.`spl_rebt` AS `spl_rebt`,`benfed_fertilizer`.`td_purchase`.`rbt_add` AS `rbt_add`,`benfed_fertilizer`.`td_purchase`.`rbt_less` AS `rbt_less`,`benfed_fertilizer`.`td_purchase`.`rnd_of_add` AS `rnd_of_add`,`benfed_fertilizer`.`td_purchase`.`rnd_of_less` AS `rnd_of_less`,`benfed_fertilizer`.`td_purchase`.`trad_margin` AS `trad_margin`,`benfed_fertilizer`.`td_purchase`.`oth_dis` AS `oth_dis`,`benfed_fertilizer`.`td_purchase`.`frt_subsidy` AS `frt_subsidy`,`benfed_fertilizer`.`td_purchase`.`tot_amt` AS `tot_amt`,`benfed_fertilizer`.`td_purchase`.`net_amt` AS `net_amt`,`benfed_fertilizer`.`td_purchase`.`add_adj_amt` AS `add_adj_amt`,`benfed_fertilizer`.`td_purchase`.`less_adj_amt` AS `less_adj_amt`,`benfed_fertilizer`.`td_purchase`.`add_ret_margin_flag` AS `add_ret_margin_flag`,`benfed_fertilizer`.`td_purchase`.`less_spl_rbt_flag` AS `less_spl_rbt_flag`,`benfed_fertilizer`.`td_purchase`.`add_adj_amt_flag` AS `add_adj_amt_flag`,`benfed_fertilizer`.`td_purchase`.`less_adj_amt_flag` AS `less_adj_amt_flag`,`benfed_fertilizer`.`td_purchase`.`less_trad_margin_flag` AS `less_trad_margin_flag`,`benfed_fertilizer`.`td_purchase`.`less_oth_dis_flag` AS `less_oth_dis_flag`,`benfed_fertilizer`.`td_purchase`.`less_frght_subsdy_flag` AS `less_frght_subsdy_flag`,`benfed_fertilizer`.`td_purchase`.`created_by` AS `created_by`,`benfed_fertilizer`.`td_purchase`.`created_dt` AS `created_dt`,`benfed_fertilizer`.`td_purchase`.`modified_by` AS `modified_by`,`benfed_fertilizer`.`td_purchase`.`modified_dt` AS `modified_dt`,`benfed_fertilizer`.`td_purchase`.`br` AS `br`,`benfed_fertilizer`.`td_purchase`.`fin_yr` AS `fin_yr`,`benfed_fertilizer`.`td_purchase`.`stock_point` AS `stock_point` from `benfed_fertilizer`.`td_purchase` ;

-- --------------------------------------------------------

--
-- Structure for view `v_sale`
--
DROP TABLE IF EXISTS `v_sale`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_sale`  AS  select `benfed_fertilizer`.`td_sale`.`trans_do` AS `inv_no`,`benfed_fertilizer`.`td_sale`.`do_dt` AS `inv_dt`,`benfed_fertilizer`.`td_sale`.`soc_id` AS `soc_id`,`benfed_fertilizer`.`td_sale`.`irn` AS `irn`,`benfed_fertilizer`.`td_sale`.`ack` AS `ack`,`benfed_fertilizer`.`td_sale`.`ack_dt` AS `ack_dt`,`benfed_fertilizer`.`td_sale`.`br_cd` AS `br_cd`,`benfed_fertilizer`.`td_sale`.`fin_yr` AS `fin_yr` from `benfed_fertilizer`.`td_sale` ;

-- --------------------------------------------------------

--
-- Structure for view `v_sale_cancel`
--
DROP TABLE IF EXISTS `v_sale_cancel`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_sale_cancel`  AS  select `benfed_fertilizer`.`td_sale_cancel`.`trans_do` AS `trans_do`,`benfed_fertilizer`.`td_sale_cancel`.`trans_no` AS `trans_no`,`benfed_fertilizer`.`td_sale_cancel`.`do_dt` AS `do_dt`,`benfed_fertilizer`.`td_sale_cancel`.`no_of_days` AS `no_of_days`,`benfed_fertilizer`.`td_sale_cancel`.`sale_due_dt` AS `sale_due_dt`,`benfed_fertilizer`.`td_sale_cancel`.`trans_type` AS `trans_type`,`benfed_fertilizer`.`td_sale_cancel`.`soc_id` AS `soc_id`,`benfed_fertilizer`.`td_sale_cancel`.`comp_id` AS `comp_id`,`benfed_fertilizer`.`td_sale_cancel`.`sale_ro` AS `sale_ro`,`benfed_fertilizer`.`td_sale_cancel`.`prod_id` AS `prod_id`,`benfed_fertilizer`.`td_sale_cancel`.`unit` AS `unit`,`benfed_fertilizer`.`td_sale_cancel`.`catg_id` AS `catg_id`,`benfed_fertilizer`.`td_sale_cancel`.`stock_point` AS `stock_point`,`benfed_fertilizer`.`td_sale_cancel`.`gov_sale_rt` AS `gov_sale_rt`,`benfed_fertilizer`.`td_sale_cancel`.`qty` AS `qty`,`benfed_fertilizer`.`td_sale_cancel`.`sale_rt` AS `sale_rt`,`benfed_fertilizer`.`td_sale_cancel`.`base_price` AS `base_price`,`benfed_fertilizer`.`td_sale_cancel`.`taxable_amt` AS `taxable_amt`,`benfed_fertilizer`.`td_sale_cancel`.`cgst` AS `cgst`,`benfed_fertilizer`.`td_sale_cancel`.`sgst` AS `sgst`,`benfed_fertilizer`.`td_sale_cancel`.`dis` AS `dis`,`benfed_fertilizer`.`td_sale_cancel`.`tot_amt` AS `tot_amt`,`benfed_fertilizer`.`td_sale_cancel`.`round_tot_amt` AS `round_tot_amt`,`benfed_fertilizer`.`td_sale_cancel`.`paid_amt` AS `paid_amt`,`benfed_fertilizer`.`td_sale_cancel`.`irn` AS `irn`,`benfed_fertilizer`.`td_sale_cancel`.`irn_cnl_reason` AS `irn_cnl_reason`,`benfed_fertilizer`.`td_sale_cancel`.`irn_cnl_rem` AS `irn_cnl_rem`,`benfed_fertilizer`.`td_sale_cancel`.`ack` AS `ack`,`benfed_fertilizer`.`td_sale_cancel`.`ack_dt` AS `ack_dt`,`benfed_fertilizer`.`td_sale_cancel`.`gst_type_flag` AS `gst_type_flag`,`benfed_fertilizer`.`td_sale_cancel`.`nwirn` AS `nwirn`,`benfed_fertilizer`.`td_sale_cancel`.`cnl_flag` AS `cnl_flag`,`benfed_fertilizer`.`td_sale_cancel`.`created_by` AS `created_by`,`benfed_fertilizer`.`td_sale_cancel`.`created_dt` AS `created_dt`,`benfed_fertilizer`.`td_sale_cancel`.`modified_by` AS `modified_by`,`benfed_fertilizer`.`td_sale_cancel`.`modified_dt` AS `modified_dt`,`benfed_fertilizer`.`td_sale_cancel`.`br_cd` AS `br_cd`,`benfed_fertilizer`.`td_sale_cancel`.`fin_yr` AS `fin_yr` from `benfed_fertilizer`.`td_sale_cancel` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `td_users`
--
ALTER TABLE `td_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `td_users`
--
ALTER TABLE `td_users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
