'use strict';

// For SQL
var mysql = require('mysql');
var squel = require('squel');

// For data genaration
var pd = require('probability-distributions');

// For control range
var inRange = (n, min, max) => {
	if (n > max) {
		return max;
	}

	if (n < min) {
		return min;
	}

	return n;
};

// Generate the worklogs for each masseur
// Assume there are at least 4 helpers and 4 shops
var oneMasseurWorklog = (mid, averageHepler, averageShop, averageAssigned, averageNotAssigned, averageGuestNum, howManyDays, startDateString) => {
	let helpers = pd.rnorm(howManyDays, averageHepler + 1, 0.8)
		.map(n => Math.abs(n))
		.map(n => Math.floor(n))
		.map(n => inRange(n, 1, 4));

	let shops = pd.rnorm(howManyDays, averageShop + 1, 0.8)
		.map(n => Math.abs(n))
		.map(n => Math.floor(n))
		.map(n => inRange(n, 1, 4));

	let assigned = pd.rnorm(howManyDays, averageAssigned + 1, 1.2)
		.map(n => Math.abs(n))
		.map(n => Math.floor(n));

	let notAssigned = pd.rnorm(howManyDays, averageNotAssigned + 1, 1.2)
		.map(n => Math.abs(n))
		.map(n => Math.floor(n));

	let guestNum = pd.rnorm(howManyDays, averageGuestNum + 1, 1.2)
		.map(n => Math.abs(n))
		.map(n => Math.floor(n));

	var output = [];
	var tmpDate = new Date(startDateString);
	for (let i = 0; i < howManyDays; i++) {
		output.push({
			mid: mid,
			hid: helpers[i],
			sid: shops[i],
			assigned: assigned[i],
			not_assigned: notAssigned[i],
			guest_num: (guestNum[i] > assigned[i] + notAssigned[i] ? assigned[i] + notAssigned[i] : guestNum[i]),
			log_date: tmpDate.toISOString().split('T')[0]
		});

		tmpDate.setDate(tmpDate.getDate() + 1);
	}

	return output;
};

// MySQL connections pool
var pool = mysql.createPool({
	connectionLimit: 1,
	host: 'ap-cdbr-azure-east-c.cloudapp.net',
	database: 'D4SG_VIM',
	user: 'b4aa79b2c77ddc',
	password: '23d314ad'
});

//m, h, s, ass, nass, gn, days, datestr
var masseurs = [];
masseurs = masseurs.concat(oneMasseurWorklog(1, 1, 2, 3, 4, 6, 30, '2015-04-01'));
masseurs = masseurs.concat(oneMasseurWorklog(2, 2, 3, 4, 3, 5, 30, '2015-04-01'));
masseurs = masseurs.concat(oneMasseurWorklog(3, 3, 4, 5, 2, 4, 30, '2015-04-01'));
masseurs = masseurs.concat(oneMasseurWorklog(4, 4, 1, 6, 1, 3, 30, '2015-04-01'));

var queryString = squel.insert()
	.into('worklog')
	.setFieldsRows(masseurs)
	.toString();

pool.query(queryString, (err, rows) => {
	if (err) throw err;

	console.log(rows);

	pool.end(err => {
		if (err) throw err;
	});
});

// console.log(queryString);
