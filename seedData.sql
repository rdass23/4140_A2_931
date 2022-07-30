/* Client Insertion */
INSERT INTO `Clients931` (`clientId931`, `clientName931`, `clientCity931`, `clientPassword931`, `moneyOwed931`) VALUES (NULL, 'Rebecca', 'Halifax', 'password', '0.00'), (NULL, 'James', 'Halifax', 'password', '0.00'), (NULL, 'Jane', 'Halifax', 'password', '0.00'), (NULL, 'Ricky', 'Halifax', 'password', '0.00'), (NULL, 'Helen', 'Halifax', 'password', '0.00') ;

/* Part Insertion */ 
INSERT INTO `Parts931` (`partNo931`, `partName931`, `currentPrice931`, `qoh931`) VALUES (NULL, 'Part1', '5.00', '100'), (NULL, 'Part2', '7.99', '50'), (NULL, 'Part3', '11.29', '78'), (NULL, 'Part4', '5.99', '84'), (NULL, 'Part5', '20.00', '129'), (NULL, 'Part6', '3.49', '28'), (NULL, 'Part7', '15.85', '97');

/* Purchase Order Insertion */
INSERT INTO `POs931` (`poNo931`, `clientCompID931`, `dateOfPO931`, `status931`) VALUES (NULL, '1', '2022-06-26', 'in progress'), (NULL, '3', '2022-06-15', 'delivered'), (NULL, '4', '2022-06-25', 'in progress'), (NULL, '2', '2022-06-24', 'in progress'), (NULL, '5', '2022-06-07', 'delivered');

/* Purchase Order Line Insertion */
INSERT INTO `Lines931` (`poNo931`, `lineNo931`, `partNo931`, `qty931`, `priceOrdered931`) VALUES ('1', '1', '2', '3', '7.99'), ('1', '2', '7', '1', '15.85'), ('1', '3', '1', '10', '5.00');