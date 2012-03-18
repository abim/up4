<?php
/*
+-------------------------------------------------------------------+
|	INDOBIT-TECHNOLOGIES
|	based 		: 02-04-2005
|	continue 	: December 2011
|
|	Released under the terms and conditions of the
|	GNU General Public License (http://gnu.org).
|
|	Rosi Abimanyu Yusuf	(bima@abimanyu.net) | Pontianak, INDONESIA
|	(c)2005 INDOBIT.COM | http://www.indobit.com
+-------------------------------------------------------------------+
*/

class STATISTICS {

	
//-------------------------------------------------------------------------//
	function POPULASI_KELAMIN_UMUR () {

?>
<script type="text/javascript">
		
			var chart,
				categories = ['0-4', '5-9', '10-14', '15-19',
					'20-24', '25-29', '30-34', '35-39', '40-44',
					'45-49', '50-54', '55-59', '60-64', '65-69',
					'70-74', '75-79', '80-84', '85-89', '90-94',
					'95-99', '100 +'];
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'POPULASI_KELAMIN_UMUR',
						defaultSeriesType: 'bar'
					},
					title: {
						text: 'Populasi Berdasarkan Jenis Kelamin dan umur'
					},
					subtitle: {
						text: 'Data Tahun 2011'
					},
					xAxis: [{
						categories: categories,
						reversed: false
					}, { // mirror axis on right side
						opposite: true,
						reversed: false,
						categories: categories,
						linkedTo: 0
					}],
					yAxis: {
						title: {
							text: null
						},
						labels: {
							formatter: function(){
								return (Math.abs(this.value) / 1000000) + 'M';
							}
						},
						min: -4000000,
						max: 4000000
					},
					
					plotOptions: {
						series: {
							stacking: 'normal'
						}
					},
					
					tooltip: {
						formatter: function(){
							return '<b>'+ this.series.name +', umur '+ this.point.category +'</b><br/>'+
								 'Populasi: '+ Highcharts.numberFormat(Math.abs(this.point.y), 0);
						}
					},
					
					series: [{
						name: 'Laki-laki',
						data: [-1746181, -1884428, -2089758, -2222362, -2537431, -2507081, -2443179,
							-2664537, -3556505, -3680231, -3143062, -2721122, -2229181, -2227768,
							-2176300, -1329968, -836804, -354784, -90569, -28367, -3878]
					}, {
						name: 'Perempuan',
						data: [1656154, 1787564, 1981671, 2108575, 2403438, 2366003, 2301402, 2519874,
							3360596, 3493473, 3050775, 2759560, 2304444, 2426504, 2568938, 1785638,
							1447162, 1005011, 330870, 130632, 21208]
					}]
				});
				
				
			});
				
		</script>
		
		<div id="POPULASI_KELAMIN_UMUR" style="width: 720px; height: 400px; margin: 0 auto"></div>
		<br/>
	
<?
	}
	
//-------------------------------------------------------------------------//
	function STAT_LINE_BASIC ($unit="loket") {

?>
<script type="text/javascript">
		
			var chart;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'STAT_LINE_BASIC',
						defaultSeriesType: 'line',
						marginRight: 130,
						marginBottom: 25
					},
					title: {
						text: 'Kunjungan <?=ucfirst($unit);?>',
						x: -20 //center
					},
					subtitle: {
						text: 'Data Tahun 2011',
						x: -20
					},
					xAxis: {
						categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 
							'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
					},
					yAxis: {
						title: {
							text: 'Jumlah Kunjungan Pasien'
						},
						plotLines: [{
							value: 0,
							width: 1,
							color: '#808080'
						}]
					},
					tooltip: {
						formatter: function() {
				                return '<b>'+ this.series.name +'</b><br/>'+
								this.x +': '+ this.y +' Pasien';
						}
					},
					legend: {
						layout: 'vertical',
						align: 'right',
						verticalAlign: 'top',
						x: -10,
						y: 100,
						borderWidth: 0
					},
					series: [{
						name: 'Pendaftar Baru',
						data: [2, 50, 30, 65, 72, 46, 100, 150, 95, 61, 90, 140]
					}, {
						name: 'Kunjungan Ulang',
						data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
					}]
				});
				
				
			});
				
		</script>
		
		<div id="STAT_LINE_BASIC" style="width: 720px; height: 400px; margin: 0 auto"></div>
		<br/>
	
<?
	}


//-------------------------------------------------------------------------//
} //END CLASS

?>