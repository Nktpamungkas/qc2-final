<?php
// NOW
    $sql_ITXVIEWKK  = db2_exec($conn1, "SELECT
                                        TRIM(PRODUCTIONORDERCODE) AS PRODUCTIONORDERCODE,
                                        TRIM(DEAMAND) AS DEMAND,
                                        ORIGDLVSALORDERLINEORDERLINE,
                                        PROJECTCODE,
                                        ORDPRNCUSTOMERSUPPLIERCODE,
                                        TRIM(SUBCODE01) AS SUBCODE01, TRIM(SUBCODE02) AS SUBCODE02, TRIM(SUBCODE03) AS SUBCODE03, TRIM(SUBCODE04) AS SUBCODE04,
                                        TRIM(SUBCODE05) AS SUBCODE05, TRIM(SUBCODE06) AS SUBCODE06, TRIM(SUBCODE07) AS SUBCODE07, TRIM(SUBCODE08) AS SUBCODE08,
                                        TRIM(SUBCODE09) AS SUBCODE09, TRIM(SUBCODE10) AS SUBCODE10, 
                                        TRIM(ITEMTYPEAFICODE) AS ITEMTYPEAFICODE,
                                        TRIM(DSUBCODE05) AS NO_WARNA,
                                        TRIM(DSUBCODE02) || '-' || TRIM(DSUBCODE03)  AS NO_HANGER,
                                        TRIM(ITEMDESCRIPTION) AS ITEMDESCRIPTION,
                                        DELIVERYDATE,
                                        CREATIONUSER_SALESORDER,
                                        LOT,
                                        QTY_PACKING_KG,
                                        QTY_PACKING_YARD
                                        -- ABSUNIQUEID_DEMAND
                                        FROM 
                                        ITXVIEWKK 
                                        WHERE 
                                        DEAMAND = '$nodemand'");
    $dt_ITXVIEWKK	= db2_fetch_assoc($sql_ITXVIEWKK);

    $sql_pelanggan_buyer 	= db2_exec($conn1, "SELECT TRIM(LANGGANAN) AS PELANGGAN, TRIM(BUYER) AS BUYER FROM ITXVIEW_PELANGGAN 
                                                WHERE ORDPRNCUSTOMERSUPPLIERCODE = '$dt_ITXVIEWKK[ORDPRNCUSTOMERSUPPLIERCODE]' 
                                                AND CODE = '$dt_ITXVIEWKK[PROJECTCODE]'");
    $dt_pelanggan_buyer		= db2_fetch_assoc($sql_pelanggan_buyer);

    $sql_po			= db2_exec($conn1, "SELECT 
                                        TRIM(EXTERNALREFERENCE) AS NO_PO, 
                                        SUM(USERPRIMARYQUANTITY) AS QTY_BRUTO 
                                    FROM 
                                        ITXVIEW_KGBRUTO 
                                    WHERE 
                                        PROJECTCODE = '$dt_ITXVIEWKK[PROJECTCODE]' 	
                                        AND ORIGDLVSALORDERLINEORDERLINE = '$dt_ITXVIEWKK[ORIGDLVSALORDERLINEORDERLINE]'
                                    GROUP BY
                                    EXTERNALREFERENCE");
    $dt_po    		= db2_fetch_assoc($sql_po);

    $sql_noitem     = db2_exec($conn1, "SELECT * FROM ORDERITEMORDERPARTNERLINK WHERE ORDPRNCUSTOMERSUPPLIERCODE = '$dt_ITXVIEWKK[ORDPRNCUSTOMERSUPPLIERCODE]' 
                                        AND SUBCODE01 = '$dt_ITXVIEWKK[SUBCODE01]' AND SUBCODE02 = '$dt_ITXVIEWKK[SUBCODE02]' 
                                        AND SUBCODE03 = '$dt_ITXVIEWKK[SUBCODE03]' AND SUBCODE04 = '$dt_ITXVIEWKK[SUBCODE04]' 
                                        AND SUBCODE05 = '$dt_ITXVIEWKK[SUBCODE05]' AND SUBCODE06 = '$dt_ITXVIEWKK[SUBCODE06]'
                                        AND SUBCODE07 = '$dt_ITXVIEWKK[SUBCODE07]' AND SUBCODE08 ='$dt_ITXVIEWKK[SUBCODE08]'
                                        AND SUBCODE09 = '$dt_ITXVIEWKK[SUBCODE09]' AND SUBCODE10 ='$dt_ITXVIEWKK[SUBCODE10]'");
    $dt_item        = db2_fetch_assoc($sql_noitem);

    $sql_lebargramasi	= db2_exec($conn1, "SELECT i.LEBAR,
                                            CASE
                                                WHEN i2.GRAMASI_KFF IS NULL THEN i2.GRAMASI_FKF
                                                ELSE i2.GRAMASI_KFF
                                            END AS GRAMASI 
                                            FROM 
                                                ITXVIEWLEBAR i 
                                            LEFT JOIN ITXVIEWGRAMASI i2 ON i2.SALESORDERCODE = '$dt_ITXVIEWKK[PROJECTCODE]' AND i2.ORDERLINE = '$dt_ITXVIEWKK[ORIGDLVSALORDERLINEORDERLINE]'
                                            WHERE 
                                                i.SALESORDERCODE = '$dt_ITXVIEWKK[PROJECTCODE]' AND i.ORDERLINE = '$dt_ITXVIEWKK[ORIGDLVSALORDERLINEORDERLINE]'");
    $dt_lg				= db2_fetch_assoc($sql_lebargramasi);

    $sql_warna		= db2_exec($conn1, "SELECT DISTINCT TRIM(WARNA) AS WARNA FROM ITXVIEWCOLOR 
                                        WHERE ITEMTYPECODE = '$dt_ITXVIEWKK[ITEMTYPEAFICODE]' 
                                        AND SUBCODE01 = '$dt_ITXVIEWKK[SUBCODE01]' 
                                        AND SUBCODE02 = '$dt_ITXVIEWKK[SUBCODE02]'
                                        AND SUBCODE03 = '$dt_ITXVIEWKK[SUBCODE03]' 
                                        AND SUBCODE04 = '$dt_ITXVIEWKK[SUBCODE04]'
                                        AND SUBCODE05 = '$dt_ITXVIEWKK[SUBCODE05]' 
                                        AND SUBCODE06 = '$dt_ITXVIEWKK[SUBCODE06]'
                                        AND SUBCODE07 = '$dt_ITXVIEWKK[SUBCODE07]' 
                                        AND SUBCODE08 = '$dt_ITXVIEWKK[SUBCODE08]'
                                        AND SUBCODE09 = '$dt_ITXVIEWKK[SUBCODE09]' 
                                        AND SUBCODE10 = '$dt_ITXVIEWKK[SUBCODE10]'");
    $dt_warna		= db2_fetch_assoc($sql_warna);

    $sql_roll		= db2_exec($conn1, "SELECT count(*) AS ROLL, s2.PRODUCTIONORDERCODE
                                        FROM STOCKTRANSACTION s2 
                                        WHERE s2.ITEMTYPECODE ='KGF' AND s2.PRODUCTIONORDERCODE = '$dt_ITXVIEWKK[PRODUCTIONORDERCODE]'
                                        GROUP BY s2.PRODUCTIONORDERCODE");
    $dt_roll   		= db2_fetch_assoc($sql_roll);

    $sql_qtyorder   = db2_exec($conn1, "SELECT DISTINCT
                                                    USEDUSERPRIMARYQUANTITY AS QTY_ORDER,
                                                    USEDUSERSECONDARYQUANTITY AS QTY_ORDER_YARD,
                                                CASE
                                                    WHEN TRIM(USERSECONDARYUOMCODE) = 'kg' THEN 'Kg'
                                                    WHEN TRIM(USERSECONDARYUOMCODE) = 'yd' THEN 'Yard'
                                                    WHEN TRIM(USERSECONDARYUOMCODE) = 'm' THEN 'Meter'
                                                    ELSE 'PCS'
                                                END AS SATUAN_QTY
                                                FROM 
                                                ITXVIEW_RESERVATION_KK 
                                                WHERE 
                                                ORDERCODE = '$nodemand'");
    $dt_qtyorder    = db2_fetch_assoc($sql_qtyorder);

    $sql_netto		= db2_exec($conn1, "SELECT * FROM ITXVIEW_NETTO WHERE CODE = '$nodemand' AND SALESORDERLINESALESORDERCODE = '$dt_ITXVIEWKK[PROJECTCODE]'");
    $d_netto		= db2_fetch_assoc($sql_netto);

    $sql_stdcckwarna    = db2_exec($conn1, "SELECT * FROM ITXVIEW_STD_CCK_WARNA WHERE SALESORDERCODE = '$dt_ITXVIEWKK[PROJECTCODE]' AND ORDERLINE = '$dt_ITXVIEWKK[ORIGDLVSALORDERLINEORDERLINE]'");
    $dt_stdcckwarna     = db2_fetch_assoc($sql_stdcckwarna);
// NOW
?>