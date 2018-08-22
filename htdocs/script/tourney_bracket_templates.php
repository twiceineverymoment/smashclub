<?php

//Pre-built bracket templates for single and double elimination tournaments
//From 4 to 32 players

$rd_se_4 = [
	"0,0,Semifinals",
	"0,1,Final"
];

$rd_se_5_8 = [
	"0,0,Round 1",
	"0,1,Round 2",
	"0,2,Final"
];

$rd_se_9_16 = [
	"0,0,Round 1",
	"0,1,Round 2",
	"0,2,Semifinals",
	"0,3,Final"
];

$rd_se_17_32 = [
	"0,0,Round 1",
	"0,1,Round 2",
	"0,2,Quarterfinals",
	"0,3,Semifinals",
	"0,4,Final"
];

$rd_de_4 = [
	"0,0,Round 1",
	"0,1,Winners Final",
	"0,2,Grand Final",
	"0,3,Grand Final (if necessary)",
	"1,0,Losers Round 1",
	"1,1,Losers Final"
];

$rd_de_5_6 = [
	"0,0,Round 1",
	"0,1,Round 2",
	"0,2,Winners Final",
	"0,3,Grand Final",
	"0,4,Grand Final (if necessary)",
	"1,0,Losers Round 1",
	"1,1,Losers Round 2",
	"1,2,Losers Final"
];

$rd_de_7_8 = [
	"0,0,Round 1",
	"0,1,Round 2",
	"0,2,Winners Final",
	"0,3,Grand Final",
	"0,4,Grand Final (if necessary)",
	"1,0,Losers Round 1",
	"1,1,Losers Round 2",
	"1,2,Losers Semifinal",
	"1,3,Losers Final"
];

$rd_de_9_12 = [
	"0,0,Round 1",
	"0,1,Round 2",
	"0,2,Winners Semifinals",
	"0,3,Winners Final",
	"0,4,Grand Final",
	"0,5,Grand Final (if necessary)",
	"1,0,Losers Round 1",
	"1,1,Losers Round 2",
	"1,2,Losers Round 3",
	"1,3,Losers Semifinal",
	"1,4,Losers Final"
];

$rd_de_13_16 = [
	"0,0,Round 1",
	"0,1,Round 2",
	"0,2,Winners Semifinals",
	"0,3,Winners Final",
	"0,4,Grand Final",
	"0,5,Grand Final (if necessary)",
	"1,0,Losers Round 1",
	"1,1,Losers Round 2",
	"1,2,Losers Round 3",
	"1,3,Losers Round 4",
	"1,4,Losers Semifinal",
	"1,5,Losers Final"
];

$rd_de_17_24 = [
	"0,0,Round 1",
	"0,1,Round 2",
	"0,2,Winners Quarterfinals",
	"0,3,Winners Semifinals",
	"0,4,Winners Final",
	"0,5,Grand Final",
	"0,6,Grand Final (if necessary)",
	"1,0,Losers Round 1",
	"1,1,Losers Round 2",
	"1,2,Losers Round 3",
	"1,3,Losers Round 4",
	"1,4,Losers Semifinals",
	"1,5,Losers Final 1",
	"1,6,Losers Final 2"
];

$rd_de_25_32 = [
	"0,0,Round 1",
	"0,1,Round 2",
	"0,2,Winners Quarterfinals",
	"0,3,Winners Semifinals",
	"0,4,Winners Final",
	"0,5,Grand Final",
	"0,6,Grand Final (if necessary)",
	"1,0,Losers Round 1",
	"1,1,Losers Round 2",
	"1,2,Losers Round 3",
	"1,3,Losers Round 4",
	"1,4,Losers Round 5",
	"1,5,Losers Semifinals",
	"1,6,Losers Final 1",
	"1,7,Losers Final 2"
];

$seed_se_4 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,1,W:1,W:2,2"
];

$seed_se_5 = [
	"1,0,0,S:1,S:2,0",
	"2,0,1,W:1,S:3,0",
	"3,0,1,S:4,S:5,0",
	"4,0,2,W:2,W:3,2"
];

$seed_se_6 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,1,W:1,S:5,0",
	"4,0,1,W:2,S:6,0",
	"5,0,2,W:3,W:4,2"
];

$seed_se_7 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,1,W:1,S:7,0",
	"5,0,1,W:2,W:3,0",
	"6,0,2,W:4,W:5,2"
];

$seed_se_8 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,1,W:1,W:2,0",
	"6,0,1,W:3,W:4,0",
	"7,0,2,W:5,W:6,2"
];

$seed_se_9 = [
	"1,0,0,S:1,S:2,0",
	"2,0,1,S:3,W:1,0",
	"3,0,1,S:4,S:5,0",
	"4,0,1,S:6,S:7,0",
	"5,0,1,S:8,S:9,0",
	"6,0,2,W:2,W:3,0",
	"7,0,2,W:4,W:5,0",
	"8,0,3,W:6,W:7,2",
];

$seed_se_10 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,1,S:5,W:1,0",
	"4,0,1,S:6,S:7,0",
	"5,0,1,S:8,W:2,0",
	"6,0,1,S:9,S:10,0",
	"7,0,2,W:3,W:4,0",
	"8,0,2,W:5,W:6,0",
	"9,0,3,W:7,W:8,2"
];

$seed_se_11 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,1,S:7,W:1,0",
	"5,0,1,S:8,S:9,0",
	"6,0,1,S:10,W:2,0",
	"7,0,1,S:11,W:3,0",
	"8,0,2,W:4,W:5,0",
	"9,0,2,W:6,W:7,0",
	"10,0,3,W:8,W:9,2"
];

$seed_se_12 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,1,S:9,W:1,0",
	"6,0,1,S:10,W:2,0",
	"7,0,1,S:11,W:3,0",
	"8,0,1,S:12,W:4,0",
	"9,0,2,W:5,W:6,0",
	"10,0,2,W:7,W:8,0",
	"11,0,3,W:9,W:10,2"
];

$seed_se_13 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,1,S:11,W:1,0",
	"7,0,1,W:2,W:3,0",
	"8,0,1,S:12,W:4,0",
	"9,0,1,S:13,W:5,0",
	"10,0,2,W:6,W:7,0",
	"11,0,2,W:8,W:9,0",
	"12,0,3,W:10,W:11,2"
];

$seed_se_14 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,0,S:11,S:12,0",
	"7,0,1,S:13,W:1,0",
	"8,0,1,W:2,W:3,0",
	"9,0,1,S:14,W:4,0",
	"10,0,1,W:5,W:6,0",
	"11,0,2,W:7,W:8,0",
	"12,0,2,W:9,W:10,0",
	"13,0,3,W:11,W:12,2"
];

$seed_se_15 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,0,S:11,S:12,0",
	"7,0,0,S:13,S:14,0",
	"8,0,1,S:15,W:1,0",
	"9,0,1,W:2,W:3,0",
	"10,0,1,W:4,W:5,0",
	"11,0,1,W:6,W:7,0",
	"12,0,2,W:8,W:9,0",
	"13,0,2,W:10,W:11,0",
	"14,0,3,W:12,W:13,2"
];

$seed_se_16 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,0,S:11,S:12,0",
	"7,0,0,S:13,S:14,0",
	"8,0,0,S:15,S:16,0",
	"9,0,1,W:1,W:2,0",
	"10,0,1,W:3,W:4,0",
	"11,0,1,W:5,W:6,0",
	"12,0,1,W:7,W:8,0",
	"13,0,2,W:9,W:10,0",
	"14,0,2,W:11,W:12,0",
	"15,0,3,W:13,W:14,2"
];

$seed_se_17 = [
	"1,0,0,S:1,S:2,0",
	"2,0,1,S:3,S:4,0",
	"3,0,1,S:5,S:6,0",
	"4,0,1,S:7,S:8,0",
	"5,0,1,S:9,S:10,0",
	"6,0,1,S:11,S:12,0",
	"7,0,1,S:13,S:14,0",
	"8,0,1,S:15,S:16,0",
	"9,0,1,W:1,S:17,0",
	"10,0,2,W:2,W:3,0",
	"11,0,2,W:4,W:5,0",
	"12,0,2,W:6,W:7,0",
	"13,0,2,W:8,W:9,0",
	"14,0,3,W:10,W:11,0",
	"15,0,3,W:12,W:13,0",
	"16,0,4,W:14,W:15,2",
];

$seed_se_18 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,1,W:1,S:5,0",
	"4,0,1,W:2,S:6,0",
	"5,0,1,S:7,S:8,0",
	"6,0,1,S:9,S:10,0",
	"7,0,1,S:11,S:12,0",
	"8,0,1,S:13,S:14,0",
	"9,0,1,S:15,S:16,0",
	"10,0,1,S:17,S:18,0",
	"11,0,2,W:3,W:4,0",
	"12,0,2,W:5,W:6,0",
	"13,0,2,W:7,W:8,0",
	"14,0,2,W:9,W:10,0",
	"15,0,3,W:11,W:12,0",
	"16,0,3,W:13,W:14,0",
	"17,0,4,W:15,W:16,2"
];

$seed_se_19 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,1,W:1,S:7,0",
	"5,0,1,W:2,S:8,0",
	"6,0,1,W:3,S:9,0",
	"7,0,1,S:10,S:11,0",
	"8,0,1,S:12,S:13,0",
	"9,0,1,S:14,S:15,0",
	"10,0,1,S:16,S:17,0",
	"11,0,1,S:18,S:19,0",
	"12,0,2,W:4,W:5,0",
	"13,0,2,W:6,W:7,0",
	"14,0,2,W:8,W:9,0",
	"15,0,2,W:10,W:11,0",
	"16,0,3,W:12,W:13,0",
	"17,0,3,W:14,W:15,0",
	"18,0,4,W:16,W:17,2"
];

$seed_se_20 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,1,S:9,S:10,0",
	"6,0,1,W:1,S:11,0",
	"7,0,1,S:12,S:13,0",
	"8,0,1,W:2,S:14,0",
	"9,0,1,S:15,S:16,0",
	"10,0,1,W:3,S:17,0",
	"11,0,1,S:18,S:19,0",
	"12,0,1,W:4,S:20,0",
	"13,0,2,W:5,W:6,0",
	"14,0,2,W:7,W:8,0",
	"15,0,2,W:9,W:10,0",
	"16,0,2,W:11,W:12,0",
	"17,0,3,W:13,W:14,0",
	"18,0,3,W:15,W:16,0",
	"19,0,4,W:17,W:18,2"
];

$seed_se_21 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,1,W:1,S:11,0",
	"7,0,1,W:2,S:12,0",
	"8,0,1,W:3,S:13,0",
	"9,0,1,W:4,S:14,0",
	"10,0,1,W:5,S:15,0",
	"11,0,1,S:16,S:17,0",
	"12,0,1,S:18,S:19,0",
	"13,0,1,S:20,S:21,0",
	"14,0,2,W:6,W:7,0",
	"15,0,2,W:8,W:9,0",
	"16,0,2,W:10,W:11,0",
	"17,0,2,W:12,W:13,0",
	"18,0,3,W:14,W:15,0",
	"19,0,3,W:16,W:17,0",
	"20,0,4,W:18,W:19,2"
];

$seed_se_22 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,0,S:11,S:12,0",
	"7,0,1,W:1,S:13,0",
	"8,0,1,W:2,S:14,0",
	"9,0,1,W:3,S:15,0",
	"10,0,1,W:4,S:16,0",
	"11,0,1,W:5,S:17,0",
	"12,0,1,W:6,S:18,0",
	"13,0,1,S:19,S:20,0",
	"14,0,1,S:21,S:22,0",
	"15,0,2,W:7,W:8,0",
	"16,0,2,W:9,W:10,0",
	"17,0,2,W:11,W:12,0",
	"18,0,2,W:13,W:14,0",
	"19,0,3,W:15,W:16,0",
	"20,0,3,W:17,W:18,0",
	"21,0,4,W:19,W:20,2"
];

$seed_se_23 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,0,S:11,S:12,0",
	"7,0,0,S:13,S:14,0",
	"8,0,1,W:1,S:15,0",
	"9,0,1,W:2,S:16,0",
	"10,0,1,W:3,S:17,0",
	"11,0,1,W:4,S:18,0",
	"12,0,1,W:5,S:19,0",
	"13,0,1,W:6,S:20,0",
	"14,0,1,W:7,S:21,0",
	"15,0,1,S:22,S:23,0",
	"16,0,2,W:8,W:9,0",
	"17,0,2,W:10,W:11,0",
	"18,0,2,W:12,W:13,0",
	"19,0,2,W:14,W:15,0",
	"20,0,3,W:16,W:17,0",
	"21,0,3,W:18,W:19,0",
	"22,0,4,W:20,W:21,2"
];

$seed_se_24 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,0,S:11,S:12,0",
	"7,0,0,S:13,S:14,0",
	"8,0,0,S:15,S:16,0",
	"9,0,1,W:1,S:17,0",
	"10,0,1,W:2,S:18,0",
	"11,0,1,W:3,S:19,0",
	"12,0,1,W:4,S:20,0",
	"13,0,1,W:5,S:21,0",
	"14,0,1,W:6,S:22,0",
	"15,0,1,W:7,S:23,0",
	"16,0,1,W:8,S:24,0",
	"17,0,2,W:9,W:10,0",
	"18,0,2,W:11,W:12,0",
	"19,0,2,W:13,W:14,0",
	"20,0,2,W:15,W:16,0",
	"21,0,3,W:17,W:18,0",
	"22,0,3,W:19,W:20,0",
	"23,0,4,W:21,W:22,2"
];

$seed_se_25 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,0,S:11,S:12,0",
	"7,0,0,S:13,S:14,0",
	"8,0,0,S:15,S:16,0",
	"9,0,0,S:17,S:18,0",
	"10,0,1,W:1,W:2,0",
	"11,0,1,W:3,S:19,0",
	"12,0,1,W:4,S:20,0",
	"13,0,1,W:5,S:21,0",
	"14,0,1,W:6,S:22,0",
	"15,0,1,W:7,S:23,0",
	"16,0,1,W:8,S:24,0",
	"17,0,1,W:9,S:25,0",
	"18,0,2,W:10,W:11,0",
	"19,0,2,W:12,W:13,0",
	"20,0,2,W:14,W:15,0",
	"21,0,2,W:16,W:17,0",
	"22,0,3,W:18,W:19,0",
	"23,0,3,W:20,W:21,0",
	"24,0,4,W:22,W:23,2"
];

$seed_se_26 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,0,S:11,S:12,0",
	"7,0,0,S:13,S:14,0",
	"8,0,0,S:15,S:16,0",
	"9,0,0,S:17,S:18,0",
	"10,0,0,S:19,S:20,0",
	"11,0,1,W:1,W:2,0",
	"12,0,1,W:3,W:4,0",
	"13,0,1,W:5,S:21,0",
	"14,0,1,W:6,S:22,0",
	"15,0,1,W:7,S:23,0",
	"16,0,1,W:8,S:24,0",
	"17,0,1,W:9,S:25,0",
	"18,0,1,W:10,S:26,0",
	"19,0,2,W:11,W:12,0",
	"20,0,2,W:13,W:14,0",
	"21,0,2,W:15,W:16,0",
	"22,0,2,W:17,W:18,0",
	"23,0,3,W:19,W:20,0",
	"24,0,3,W:11,W:22,0",
	"25,0,4,W:23,W:24,2"
];

$seed_se_27 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,0,S:11,S:12,0",
	"7,0,0,S:13,S:14,0",
	"8,0,0,S:15,S:16,0",
	"9,0,0,S:17,S:18,0",
	"10,0,0,S:19,S:20,0",
	"11,0,0,S:21,S:22,0",
	"12,0,1,W:1,W:2,0",
	"13,0,1,W:3,W:4,0",
	"14,0,1,W:5,W:6,0",
	"15,0,1,W:7,S:23,0",
	"16,0,1,W:8,S:24,0",
	"17,0,1,W:9,S:25,0",
	"18,0,1,W:10,S:26,0",
	"19,0,1,W:11,S:27,0",
	"20,0,2,W:12,W:13,0",
	"21,0,2,W:14,W:15,0",
	"22,0,2,W:16,W:17,0",
	"23,0,2,W:18,W:19,0",
	"24,0,3,W:20,W:21,0",
	"25,0,3,W:22,W:23,0",
	"26,0,4,W:24,W:25,2"
];

$seed_se_28 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,0,S:11,S:12,0",
	"7,0,0,S:13,S:14,0",
	"8,0,0,S:15,S:16,0",
	"9,0,0,S:17,S:18,0",
	"10,0,0,S:19,S:20,0",
	"11,0,0,S:21,S:22,0",
	"12,0,0,S:23,S:24,0",
	"13,0,1,W:1,W:2,0",
	"14,0,1,W:3,W:4,0",
	"15,0,1,W:5,W:6,0",
	"16,0,1,W:7,W:8,0",
	"17,0,1,W:9,S:25,0",
	"18,0,1,W:10,S:26,0",
	"19,0,1,W:11,S:27,0",
	"20,0,1,W:12,S:28,0",
	"21,0,2,W:13,W:14,0",
	"22,0,2,W:15,W:16,0",
	"23,0,2,W:17,W:18,0",
	"24,0,2,W:19,W:20,0",
	"25,0,3,W:21,W:22,0",
	"26,0,3,W:23,W:24,0",
	"27,0,4,W:25,W:26,2"
];

$seed_se_29 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,0,S:11,S:12,0",
	"7,0,0,S:13,S:14,0",
	"8,0,0,S:15,S:16,0",
	"9,0,0,S:17,S:18,0",
	"10,0,0,S:19,S:20,0",
	"11,0,0,S:21,S:22,0",
	"12,0,0,S:23,S:24,0",
	"13,0,0,S:25,S:26,0",
	"14,0,1,W:1,W:2,0",
	"15,0,1,W:3,W:4,0",
	"16,0,1,W:5,W:6,0",
	"17,0,1,W:7,W:8,0",
	"18,0,1,W:9,W:10,0",
	"19,0,1,W:11,S:27,0",
	"20,0,1,W:12,S:28,0",
	"21,0,1,W:13,S:29,0",
	"22,0,2,W:14,W:15,0",
	"23,0,2,W:16,W:17,0",
	"24,0,2,W:18,W:19,0",
	"25,0,2,W:20,W:21,0",
	"26,0,3,W:22,W:23,0",
	"27,0,3,W:24,W:25,0",
	"28,0,4,W:26,W:27,2"
];

$seed_se_30 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,0,S:11,S:12,0",
	"7,0,0,S:13,S:14,0",
	"8,0,0,S:15,S:16,0",
	"9,0,0,S:17,S:18,0",
	"10,0,0,S:19,S:20,0",
	"11,0,0,S:21,S:22,0",
	"12,0,0,S:23,S:24,0",
	"13,0,0,S:25,S:26,0",
	"14,0,0,S:27,S:28,0",
	"15,0,1,W:1,W:2,0",
	"16,0,1,W:3,W:4,0",
	"17,0,1,W:5,W:6,0",
	"18,0,1,W:7,W:8,0",
	"19,0,1,W:9,W:10,0",
	"20,0,1,W:11,W:12,0",
	"21,0,1,W:13,S:29,0",
	"22,0,1,W:14,S:30,0",
	"23,0,2,W:15,W:16,0",
	"24,0,2,W:17,W:18,0",
	"25,0,2,W:19,W:20,0",
	"26,0,2,W:21,W:22,0",
	"27,0,3,W:23,W:24,0",
	"28,0,3,W:25,W:26,0",
	"29,0,4,W:27,W:28,2"
];

$seed_se_31 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,0,S:11,S:12,0",
	"7,0,0,S:13,S:14,0",
	"8,0,0,S:15,S:16,0",
	"9,0,0,S:17,S:18,0",
	"10,0,0,S:19,S:20,0",
	"11,0,0,S:21,S:22,0",
	"12,0,0,S:23,S:24,0",
	"13,0,0,S:25,S:26,0",
	"14,0,0,S:27,S:28,0",
	"15,0,0,S:29,S:30,0",
	"16,0,1,W:1,W:2,0",
	"17,0,1,W:3,W:4,0",
	"18,0,1,W:5,W:6,0",
	"19,0,1,W:7,W:8,0",
	"20,0,1,W:9,W:10,0",
	"21,0,1,W:11,W:12,0",
	"22,0,1,W:13,W:14,0",
	"23,0,1,W:15,S:31,0",
	"24,0,2,W:16,W:17,0",
	"25,0,2,W:18,W:19,0",
	"26,0,2,W:20,W:21,0",
	"27,0,2,W:22,W:23,0",
	"28,0,3,W:24,W:25,0",
	"29,0,3,W:26,W:27,0",
	"30,0,4,W:28,W:29,2"
];

$seed_se_32 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,0,S:11,S:12,0",
	"7,0,0,S:13,S:14,0",
	"8,0,0,S:15,S:16,0",
	"9,0,0,S:17,S:18,0",
	"10,0,0,S:19,S:20,0",
	"11,0,0,S:21,S:22,0",
	"12,0,0,S:23,S:24,0",
	"13,0,0,S:25,S:26,0",
	"14,0,0,S:27,S:28,0",
	"15,0,0,S:29,S:30,0",
	"16,0,0,S:31,S:32,0",
	"17,0,1,W:1,W:2,0",
	"18,0,1,W:3,W:4,0",
	"19,0,1,W:5,W:6,0",
	"20,0,1,W:7,W:8,0",
	"21,0,1,W:9,W:10,0",
	"22,0,1,W:11,W:12,0",
	"23,0,1,W:13,W:14,0",
	"24,0,1,W:15,W:16,0",
	"25,0,2,W:17,W:18,0",
	"26,0,2,W:19,W:20,0",
	"27,0,2,W:21,W:22,0",
	"28,0,2,W:23,W:24,0",
	"29,0,3,W:25,W:26,0",
	"30,0,3,W:27,W:28,0",
	"31,0,4,W:29,W:30,2"
];

$seed_de_4 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,1,0,L:1,L:2,0",
	"4,0,1,W:1,W:2,0",
	"5,1,1,L:4,W:3,0",
	"6,0,2,W:4,W:5,1",
	"7,0,3,W:6,L:6,2"
];

$seed_de_5 = [
	"1,0,0,S:1,S:2,0",
	"2,0,1,S:3,S:4,0",
	"3,0,1,W:1,S:5,0",
	"4,1,0,L:1,L:2,0",
	"5,1,1,W:4,L:3,0",
	"6,0,2,W:2,W:3,0",
	"7,1,2,L:6,W:5,0",
	"8,0,3,W:6,W:7,1",
	"9,0,4,W:8,L:8,2"
];

$seed_de_6 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,1,S:5,W:1,0",
	"4,0,1,S:6,W:2,0",
	"5,1,0,L:2,L:3,0",
	"6,1,0,L:1,L:4,0",
	"7,0,2,W:3,W:4,0",
	"8,1,1,W:5,W:6,0",
	"9,1,2,W:8,L:7,0",
	"10,0,3,W:7,W:9,1",
	"11,0,4,W:10,L:10,2"
];

$seed_de_7 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,1,W:1,S:7,0",
	"5,0,1,W:2,W:3,0",
	"6,1,0,L:2,L:3,0",
	"7,1,1,L:1,L:5,0",
	"8,1,1,L:4,W:6,0",
	"9,0,2,W:4,W:5,0",
	"10,1,2,W:7,W:8,0",
	"11,1,3,L:9,W:10,0",
	"12,0,3,W:9,W:11,1",
	"13,0,4,W:12,L:12,2"
];

$seed_de_8 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,1,0,L:1,L:2,0",
	"6,1,0,L:3,L:4,0",
	"7,0,1,W:1,W:2,0",
	"8,0,1,W:3,W:4,0",
	"9,1,1,L:8,W:5,0",
	"10,1,1,W:6,L:7,0",
	"11,0,2,W:7,W:8,0",
	"12,1,2,W:9,W:10,0",
	"13,1,3,L:11,W:12,0",
	"14,0,3,W:11,W:13,1",
	"15,0,4,W:14,L:14,2"
];

$seed_de_9 = [
	"1,0,0,S:1,S:2,0",
	"2,0,1,S:3,S:4,0",
	"3,0,1,S:5,S:6,0",
	"4,0,1,S:7,S:8,0",
	"5,0,1,W:1,S:9,0",
	"6,1,0,L:1,L:2,0",
	"7,1,1,L:4,L:5,0",
	"8,1,1,W:6,L:3,0",
	"9,0,2,W:2,W:3,0",
	"10,0,2,W:4,W:5,0",
	"11,1,2,W:7,L:9,0",
	"12,1,2,W:8,L:10,0",
	"13,0,3,W:9,W:10,0",
	"14,1,3,W:11,W:12,0",
	"15,1,4,W:14,L:13,0",
	"16,0,4,W:13,W:15,1",
	"17,0,5,W:16,L:16,2"
];

$seed_de_10 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,1,S:5,S:6,0",
	"4,0,1,S:7,S:8,0",
	"5,0,1,W:1,S:9,0",
	"6,0,1,W:2,S:10,0",
	"7,1,0,L:2,L:5,0",
	"8,1,0,L:1,L:6,0",
	"9,1,1,W:7,L:3,0",
	"10,1,1,W:8,L:4,0",
	"11,0,2,W:3,W:4,0",
	"12,0,2,W:5,W:6,0",
	"13,1,2,W:9,L:12,0",
	"14,1,2,W:10,L:11,0",
	"15,0,3,W:11,W:12,0",
	"16,1,3,W:13,W:14,0",
	"17,1,4,W:16,L:15,0",
	"18,0,4,W:15,W:17,1",
	"19,0,5,W:18,L:18,2"
];

$seed_de_11 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,1,S:7,S:8,0",
	"5,0,1,W:1,S:9,0",
	"6,0,1,W:2,S:10,0",
	"7,0,1,W:3,S:11,0",
	"8,1,0,L:2,L:4,0",
	"9,1,0,L:3,L:5,0",
	"10,1,0,L:1,L:7,0",
	"11,1,1,W:8,W:9,0",
	"12,1,1,L:6,W:10,0",
	"13,0,2,W:4,W:5,0",
	"14,0,2,W:6,W:7,0",
	"15,1,2,W:12,L:13,0",
	"16,1,2,W:11,L:14,0",
	"17,0,3,W:13,W:14,0",
	"18,1,3,W:16,W:17,0",
	"19,1,4,L:17,W:18,0",
	"20,0,4,W:17,W:19,1",
	"21,0,5,W:20,L:20,2"
];

$seed_de_12 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,1,W:1,S:9,0",
	"6,0,1,W:2,S:10,0",
	"7,0,1,W:3,S:11,0",
	"8,0,1,W:4,S:12,0",
	"9,1,0,L:3,L:6,0",
	"10,1,0,L:4,L:5,0",
	"11,1,0,L:1,L:8,0",
	"12,1,0,L:2,L:7,0",
	"13,0,2,W:5,W:6,0",
	"14,0,2,W:7,W:8,0",
	"15,1,1,W:9,W:10,0",
	"16,1,1,W:11,W:12,0",
	"17,1,2,L:14,W:15,0",
	"18,1,2,L:13,W:16,0",
	"19,0,3,W:13,W:14,0",
	"20,1,3,W:17,W:18,0",
	"21,1,4,L:19,W:20,0",
	"22,0,4,W:19,W:21,1",
	"23,0,5,W:22,L:22,2"
];

$seed_de_13 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,1,S:11,W:1,0",
	"7,0,1,S:12,W:2,0",
	"8,0,1,W:3,W:4,0",
	"9,0,1,W:5,S:13,0",
	"10,1,0,L:3,L:4,0",
	"11,1,1,L:5,L:6,0",
	"12,1,1,L:1,L:8,0",
	"13,1,1,L:2,L:9,0",
	"14,1,1,W:10,L:7,0",
	"15,0,2,W:6,W:7,0",
	"16,0,2,W:8,W:9,0",
	"17,1,2,W:14,W:11,0",
	"18,1,2,W:12,W:13,0",
	"19,1,3,L:16,W:17,0",
	"20,1,3,L:15,W:18,0",
	"21,0,3,W:15,W:16,0",
	"22,1,4,W:19,W:20,0",
	"23,1,5,L:21,W:22,0",
	"24,0,4,W:21,W:23,1",
	"25,0,5,W:24,L:24,2",
];

$seed_de_14 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,0,S:11,S:12,0",
	"7,0,1,S:13,W:1,0",
	"8,0,1,W:2,W:3,0",
	"9,0,1,W:4,W:5,0",
	"10,0,1,W:6,S:14,0",
	"11,1,0,L:4,L:5,0",
	"12,1,0,L:2,L:3,0",
	"13,1,1,L:8,W:11,0",
	"14,1,1,L:6,L:7,0",
	"15,1,1,L:1,L:10,0",
	"16,1,1,L:9,W:12,0",
	"17,0,2,W:7,W:8,0",
	"18,0,2,W:9,W:10,0",
	"19,1,2,W:13,W:14,0",
	"20,1,2,W:15,W:16,0",
	"21,1,3,W:19,L:18,0",
	"22,1,3,W:20,L:17,0",
	"23,1,4,W:21,W:22,0",
	"24,0,3,W:17,W:18,0",
	"25,1,5,L:24,W:23,0",
	"26,0,4,W:24,W:25,1",
	"27,0,5,W:26,L:26,2"
];

$seed_de_15 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,0,S:11,S:12,0",
	"7,0,0,S:13,S:14,0",
	"8,0,1,S:15,W:1,0",
	"9,0,1,W:2,W:3,0",
	"10,0,1,W:4,W:5,0",
	"11,0,1,W:6,W:7,0",
	"12,1,0,L:4,L:5,0",
	"13,1,0,L:6,L:7,0",
	"14,1,0,L:2,L:3,0",
	"15,1,1,L:9,W:12,0",
	"16,1,1,L:8,W:13,0",
	"17,1,1,L:1,L:11,0",
	"18,1,1,L:10,W:14,0",
	"19,0,2,W:8,W:9,0",
	"20,0,2,W:10,W:11,0",
	"21,1,2,W:15,W:16,0",
	"22,1,2,W:17,W:18,0",
	"23,1,3,L:20,W:21,0",
	"24,1,3,L:19,W:22,0",
	"25,0,3,W:19,W:20,0",
	"26,1,4,W:23,W:24,0",
	"27,1,5,W:26,L:25,0",
	"28,0,4,W:25,W:27,1",
	"29,0,5,W:28,L:28,2"
];

$seed_de_16 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,0,S:11,S:12,0",
	"7,0,0,S:13,S:14,0",
	"8,0,0,S:15,S:16,0",
	"9,1,0,L:1,L:2,0",
	"10,1,0,L:3,L:4,0",
	"11,1,0,L:5,L:6,0",
	"12,1,0,L:7,L:8,0",
	"13,0,1,W:1,W:2,0",
	"14,0,1,W:3,W:4,0",
	"15,0,1,W:5,W:6,0",
	"16,0,1,W:7,W:8,0",
	"17,1,1,L:16,W:9,0",
	"18,1,1,L:15,W:10,0",
	"19,1,1,L:14,W:11,0",
	"20,1,1,L:13,W:12,0",
	"21,0,2,W:13,W:14,0",
	"22,0,2,W:15,W:16,0",
	"23,1,2,W:17,W:18,0",
	"24,1,2,W:19,W:20,0",
	"25,1,3,L:22,W:23,0",
	"26,1,3,L:21,W:24,0",
	"27,0,3,W:21,W:22,0",
	"28,1,4,W:25,W:26,0",
	"29,1,5,L:27,W:28,0",
	"30,0,4,W:27,W:29,1",
	"31,0,5,W:30,L:30,2"
];

$seed_de_17 = [
	"1,0,0,S:1,S:2,0",
	"2,0,1,S:3,S:4,0",
	"3,0,1,S:5,S:6,0",
	"4,0,1,S:7,S:8,0",
	"5,0,1,S:9,S:10,0",
	"6,0,1,S:11,S:12,0",
	"7,0,1,S:13,S:14,0",
	"8,0,1,S:15,S:16,0",
	"9,0,1,W:1,S:17,0",
	"10,1,0,L:1,L:5,0",
	"11,1,1,L:7,L:8,0",
	"12,1,1,L:9,L:2,0",
	"13,1,1,L:3,L:4,0",
	"14,1,1,W:10,L:6,0",
	"15,0,2,W:2,W:3,0",
	"16,0,2,W:4,W:5,0",
	"17,0,2,W:6,W:7,0",
	"18,0,2,W:8,W:9,0",
	"19,1,2,L:15,W:11,0",
	"20,1,2,L:16,W:12,0",
	"21,1,2,L:17,W:13,0",
	"22,1,2,L:18,W:14,0",
	"23,0,3,W:15,W:16,0",
	"24,0,3,W:17,W:18,0",
	"25,1,3,W:19,W:20,0",
	"26,1,3,W:21,W:22,0",
	"27,1,4,L:24,W:25,0",
	"28,1,4,L:23,W:26,0",
	"29,0,4,W:23,W:24,0",
	"30,1,5,W:27,W:28,0",
	"31,1,6,W:30,L:29,0",
	"32,0,5,W:29,W:31,1",
	"33,0,6,W:32,L:32,2"
];

$seed_de_18 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,1,W:1,S:5,0",
	"4,0,1,W:2,S:6,0",
	"5,0,1,S:7,S:8,0",
	"6,0,1,S:9,S:10,0",
	"7,0,1,S:11,S:12,0",
	"8,0,1,S:13,S:14,0",
	"9,0,1,S:15,S:16,0",
	"10,0,1,S:17,S:18,0",
	"11,1,0,L:1,L:10,0",
	"12,1,0,L:2,L:9,0",
	"13,1,1,L:7,L:8,0",
	"14,1,1,L:4,L:5,0",
	"15,1,1,W:11,L:6,0",
	"16,1,1,W:12,L:3,0",
	"17,0,2,W:3,W:4,0",
	"18,0,2,W:5,W:6,0",
	"19,0,2,W:7,W:8,0",
	"20,0,2,W:9,W:10,0",
	"21,1,2,L:17,W:13,0",
	"22,1,2,L:18,W:14,0",
	"23,1,2,L:19,W:15,0",
	"24,1,2,L:20,W:16,0",
	"25,0,3,W:17,W:18,0",
	"26,0,3,W:19,W:20,0",
	"27,1,3,W:21,W:22,0",
	"28,1,3,W:23,W:24,0",
	"29,1,4,L:26,W:27,0",
	"30,1,4,L:25,W:28,0",
	"31,0,4,W:25,W:26,0",
	"32,1,5,W:29,W:30,0",
	"33,1,6,L:31,W:32,0",
	"34,0,5,W:31,W:33,1",
	"35,0,6,W:34,L:34,2"
];

$seed_de_19 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,1,W:1,S:7,0",
	"5,0,1,W:2,S:8,0",
	"6,0,1,W:3,S:9,0",
	"7,0,1,S:10,S:11,0",
	"8,0,1,S:12,S:13,0",
	"9,0,1,S:14,S:15,0",
	"10,0,1,S:16,S:17,0",
	"11,0,1,S:18,S:19,0",
	"12,1,0,L:1,L:10,0",
	"13,1,0,L:2,L:9,0",
	"14,1,0,L:3,L:5,0",
	"15,1,1,L:11,L:8,0",
	"16,1,1,W:12,L:7,0",
	"17,1,1,W:13,L:4,0",
	"18,1,1,W:14,L:6,0",
	"19,0,2,W:4,W:5,0",
	"20,0,2,W:6,W:7,0",
	"21,0,2,W:8,W:9,0",
	"22,0,2,W:10,W:11,0",
	"23,1,2,L:19,W:15,0",
	"24,1,2,L:20,W:16,0",
	"25,1,2,L:21,W:17,0",
	"26,1,2,L:22,W:18,0",
	"27,0,3,W:19,W:20,0",
	"28,0,3,W:21,W:22,0",
	"29,1,3,W:23,W:24,0",
	"30,1,3,W:25,W:26,0",
	"31,1,4,L:28,W:29,0",
	"32,1,4,L:27,W:30,0",
	"33,0,4,W:27,W:28,0",
	"34,1,5,W:31,W:32,0",
	"35,1,6,L:33,W:34,0",
	"36,0,5,W:33,W:35,1",
	"37,0,6,W:36,L:36,2"
];

$seed_de_20 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,1,S:9,S:10,0",
	"6,0,1,W:1,S:11,0",
	"7,0,1,S:12,S:13,0",
	"8,0,1,W:2,S:14,0",
	"9,0,1,S:15,S:16,0",
	"10,0,1,W:3,S:17,0",
	"11,0,1,S:18,S:19,0",
	"12,0,1,W:4,S:20,0",
	"13,1,0,L:1,L:11,0",
	"14,1,0,L:2:L:12,0",
	"15,1,0,L:3,L:9,0",
	"16,1,0,L:4,L:10,0",
	"17,1,1,L:7,W:13,0",
	"18,1,1,L:8,W:14,0",
	"19,1,1,L:5,W:15,0",
	"20,1,1,L:6,W:16,0",
	"21,0,2,W:5,W:6,0",
	"22,0,2,W:7,W:8,0",
	"23,0,2,W:9,W:10,0",
	"24,0,2,W:11,W:12,0",
	"25,1,2,L:21,W:17,0",
	"26,1,2,L:22,W:18,0",
	"27,1,2,L:23,W:19,0",
	"28,1,2,L:24,W:20,0",
	"29,0,3,W:21,W:22,0",
	"30,0,3,W:23,W:24,0",
	"31,1,3,W:25,W:26,0",
	"32,1,3,W:27,W:28,0",
	"33,1,4,L:30,W:31,0",
	"34,1,4,L:29,W:32,0",
	"35,0,4,W:29,W:30,0",
	"36,1,5,W:33,W:34,0",
	"37,1,6,L:35,W:36,0",
	"38,0,5,W:35,W:37,1",
	"39,0,6,W:38,L:38,2"
];

$seed_de_21 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,1,W:1,S:11,0",
	"7,0,1,W:2,S:12,0",
	"8,0,1,W:3,S:13,0",
	"9,0,1,W:4,S:14,0",
	"10,0,1,W:5,S:15,0",
	"11,0,1,S:16,S:17,0",
	"12,0,1,S:18,S:19,0",
	"13,0,1,S:20,S:21,0",
	"14,1,0,L:1,L:12,0",
	"15,1,0,L:2,L:13,0",
	"16,1,0,L:3,L:8,0",
	"17,1,0,L:9,L:4,0",
	"18,1,0,L:10,L:5,0",
	"19,1,1,W:14,L:7,0",
	"20,1,1,W:15,W:16,0",
	"21,1,1,W:17,L:6,0",
	"22,1,1,W:18,L:11,0",
	"23,0,2,W:6,W:7,0",
	"24,0,2,W:8,W:9,0",
	"25,0,2,W:10,W:11,0",
	"26,0,2,W:12,W:13,0",
	"27,1,2,L:23,W:19,0",
	"28,1,2,L:24,W:20,0",
	"29,1,2,L:25,W:21,0",
	"30,1,2,L:26,W:22,0",
	"31,0,3,W:23,W:24,0",
	"32,0,3,W:25,W:26,0",
	"33,1,3,W:27,W:28,0",
	"34,1,3,W:29,W:30,0",
	"35,1,4,L:31,W:33,0",
	"36,1,4,L:32,W:34,0",
	"37,0,4,W:31,W:32,0",
	"38,1,5,W:35,W:36,0",
	"39,1,6,L:37,W:38,0",
	"40,0,5,W:37,W:39,1",
	"41,0,6,W:40,L:40,2"
];

$seed_de_22 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,0,S:11,S:12,0",
	"7,0,1,W:1,S:13,0",
	"8,0,1,W:2,S:14,0",
	"9,0,1,W:3,S:15,0",
	"10,0,1,W:4,S:16,0",
	"11,0,1,W:5,S:17,0",
	"12,0,1,W:6,S:18,0",
	"13,0,1,S:19,S:20,0",
	"14,0,1,S:21,S:22,0",
	"15,1,0,L:1,L:12,0",
	"16,1,0,L:2,L:11,0",
	"17,1,0,L:3,L:10,0",
	"18,1,0,L:4,L:9,0",
	"19,1,0,L:5,L:8,0",
	"20,1,0,L:6,L:7,0",
	"21,1,1,W:15,W:16,0",
	"22,1,1,W:17,W:18,0",
	"23,1,1,W:19,W:20,0",
	"24,1,1,L:13,L:14,0",
	"25,0,2,W:7,W:8,0",
	"26,0,2,W:9,W:10,0",
	"27,0,2,W:11,W:12,0",
	"28,0,2,W:13,W:14,0",
	"29,1,2,L:25,W:21,0",
	"30,1,2,L:26,W:22,0",
	"31,1,2,L:27,W:23,0",
	"32,1,2,L:28,W:24,0",
	"33,0,3,W:25,W:26,0",
	"34,0,3,W:27,W:28,0",
	"35,1,3,W:29,W:30,0",
	"36,1,3,W:31,W:32,0",
	"37,1,4,L:33,W:35,0",
	"38,1,4,L:34,W:36,0",
	"39,0,4,W:33,W:34,0",
	"40,1,5,W:37,W:38,0",
	"41,1,6,L:39,W:40,0",
	"42,0,5,W:39,W:41,1",
	"43,0,6,W:42,L:42,2"
];

$seed_de_23 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,0,S:11,S:12,0",
	"7,0,0,S:13,S:14,0",
	"8,0,1,W:1,S:15,0",
	"9,0,1,W:2,S:16,0",
	"10,0,1,W:3,S:17,0",
	"11,0,1,W:4,S:18,0",
	"12,0,1,W:5,S:19,0",
	"13,0,1,W:6,S:20,0",
	"14,0,1,W:7,S:21,0",
	"15,0,1,S:22,S:23,0",
	"16,1,0,L:1,L:14,0",
	"17,1,0,L:2,L:13,0",
	"18,1,0,L:3,L:12,0",
	"19,1,0,L:4,L:11,0",
	"20,1,0,L:5,L:10,0",
	"21,1,0,L:6,L:9,0",
	"22,1,0,L:7,L:8,0",
	"23,1,1,W:16,W:17,0",
	"24,1,1,W:18,W:19,0",
	"25,1,1,W:20,W:21,0",
	"26,1,1,W:22,L:15,0",
	"27,0,2,W:8,W:9,0",
	"28,0,2,W:10,W:11,0",
	"29,0,2,W:12,W:13,0",
	"30,0,2,W:14,W:15,0",
	"31,1,2,L:27,W:23,0",
	"32,1,2,L:28,W:24,0",
	"33,1,2,L:29,W:25,0",
	"34,1,2,L:30,W:26,0",
	"35,0,3,W:28,W:29,0",
	"36,0,3,W:30,W:31,0",
	"37,1,3,W:31,W:32,0",
	"38,1,3,W:33,W:34,0",
	"39,1,4,W:37,L:35,0",
	"40,1,4,W:38,L:36,0",
	"41,0,4,W:35,W:36,0",
	"42,1,5,W:39,W:40,0",
	"43,1,6,L:41,W:42,0",
	"44,0,5,W:41,W:43,1",
	"45,0,6,W:44,L:44,2"
];

$seed_de_24 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,0,S:11,S:12,0",
	"7,0,0,S:13,S:14,0",
	"8,0,0,S:15,S:16,0",
	"9,0,1,W:1,S:17,0",
	"10,0,1,W:2,S:18,0",
	"11,0,1,W:3,S:19,0",
	"12,0,1,W:4,S:20,0",
	"13,0,1,W:5,S:21,0",
	"14,0,1,W:6,S:22,0",
	"15,0,1,W:7,S:23,0",
	"16,0,1,W:8,S:24,0",
	"17,1,0,L:1,L:16,0",
	"18,1,0,L:2,L:15,0",
	"19,1,0,L:3,L:14,0",
	"20,1,0,L:4,L:13,0",
	"21,1,0,L:5,L:12,0",
	"22,1,0,L:6,L:11,0",
	"23,1,0,L:7,L:10,0",
	"24,1,0,L:8,L:9,0",
	"25,1,1,W:17,W:18,0",
	"26,1,1,W:19,W:20,0",
	"27,1,1,W:21,W:22,0",
	"28,1,1,W:23,W:24,0",
	"29,0,2,W:9,W:10,0",
	"30,0,2,W:11,W:12,0",
	"31,0,2,W:13,W:14,0",
	"32,0,2,W:15,W:16,0",
	"33,1,2,L:29,W:25,0",
	"34,1,2,L:30,W:26,0",
	"35,1,2,L:31,W:27,0",
	"36,1,2,L:32,W:28,0",
	"37,0,3,W:29,W:30,0",
	"38,0,3,W:31,W:32,0",
	"39,1,3,W:33,W:34,0",
	"40,1,3,W:35,W:36,0",
	"41,1,4,L:37,W:39,0",
	"42,1,4,L:38,W:40,0",
	"43,0,4,W:37,W:38,0",
	"44,1,5,W:41,W:42,0",
	"45,1,6,L:43,W:44,0",
	"46,0,5,W:43,W:45,1",
	"47,0,6,W:45,L:45,2"
];

$seed_de_25 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,0,S:11,S:12,0",
	"7,0,0,S:13,S:14,0",
	"8,0,0,S:15,S:16,0",
	"9,0,0,S:17,S:18,0",
	"10,0,1,W:1,W:2,0",
	"11,0,1,W:3,S:19,0",
	"12,0,1,W:4,S:20,0",
	"13,0,1,W:5,S:21,0",
	"14,0,1,W:6,S:22,0",
	"15,0,1,W:7,S:23,0",
	"16,0,1,W:8,S:24,0",
	"17,0,1,W:9,S:25,0",
	"18,1,0,L:1,L:2,0",
	"19,1,1,L:3,L:17,0",
	"20,1,1,L:4,L:16,0",
	"21,1,1,L:5,L:15,0",
	"22,1,1,L:6,L:14,0",
	"23,1,1,L:7,L:13,0",
	"24,1,1,L:8,L:12,0",
	"25,1,1,L:9,L:11,0",
	"26,1,1,W:18,L:10,0",
	"27,0,2,W:10,W:11,0",
	"28,0,2,W:12,W:13,0",
	"29,0,2,W:14,W:15,0",
	"30,0,2,W:16,W:17,0",
	"31,1,2,W:19,W:20,0",
	"32,1,2,W:21,W:22,0",
	"33,1,2,W:23,W:24,0",
	"34,1,2,W:25,W:26,0",
	"35,1,3,L:27,W:31,0",
	"36,1,3,L:28,W:32,0",
	"37,1,3,L:29,W:33,0",
	"38,1,3,L:30,W:34,0",
	"39,0,3,W:27,W:28,0",
	"40,0,3,W:29,W:30,0",
	"41,1,4,W:35,W:36,0",
	"42,1,4,W:37,W:38,0",
	"43,1,5,L:39,W:41,0",
	"44,1,5,L:40,W:42,0",
	"45,0,4,W:39,W:40,0",
	"46,1,6,W:43,W:44,0",
	"47,1,7,L:45,W:46,0",
	"48,0,5,W:45,W:47,1",
	"49,0,6,W:48,L:48,2"
];

$seed_de_26 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,0,S:11,S:12,0",
	"7,0,0,S:13,S:14,0",
	"8,0,0,S:15,S:16,0",
	"9,0,0,S:17,S:18,0",
	"10,0,0,S:19,S:20,0",
	"11,0,1,W:1,W:2,0",
	"12,0,1,W:3,W:4,0",
	"13,0,1,W:5,S:21,0",
	"14,0,1,W:6,S:22,0",
	"15,0,1,W:7,S:23,0",
	"16,0,1,W:8,S:24,0",
	"17,0,1,W:9,S:25,0",
	"18,0,1,W:10,S:26,0",
	"19,1,0,L:1,L:4,0",
	"20,1,0,L:2,L:3,0",
	"21,1,1,L:5,L:18,0",
	"22,1,1,L:6,L:17,0",
	"23,1,1,L:7,L:16,0",
	"24,1,1,L:8,L:15,0",
	"25,1,1,L:9,L:14,0",
	"26,1,1,L:10,L:13,0",
	"27,1,1,W:19,L:11,0",
	"28,1,1,W:20,L:12,0",
	"29,0,2,W:11,W:12,0",
	"30,0,2,W:13,W:14,0",
	"31,0,2,W:15,W:16,0",
	"32,0,2,W:17,W:18,0",
	"33,1,2,W:21,W:22,0",
	"34,1,2,W:23,W:24,0",
	"35,1,2,W:25,W:26,0",
	"36,1,2,W:27,W:28,0",
	"37,1,3,L:29,W:33,0",
	"38,1,3,L:30,W:34,0",
	"39,1,3,L:31,W:35,0",
	"40,1,3,L:32,W:36,0",
	"41,0,3,W:29,W:30,0",
	"42,0,3,W:31,W:32,0",
	"43,1,4,W:37,W:38,0",
	"44,1,4,W:39,W:40,0",
	"45,1,5,L:41,W:43,0",
	"46,1,5,L:42,W:44,0",
	"47,0,4,W:41,W:42,0",
	"48,1,6,W:45,W:46,0",
	"49,1,7,L:47,W:48,0",
	"50,0,5,W:47,W:49,1",
	"51,0,6,W:50,L:50,2"
];

$seed_de_27 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,0,S:11,S:12,0",
	"7,0,0,S:13,S:14,0",
	"8,0,0,S:15,S:16,0",
	"9,0,0,S:17,S:18,0",
	"10,0,0,S:19,S:20,0",
	"11,0,0,S:21,S:22,0",
	"12,0,1,W:1,W:2,0",
	"13,0,1,W:3,W:4,0",
	"14,0,1,W:5,W:6,0",
	"15,0,1,W:7,S:23,0",
	"16,0,1,W:8,S:24,0",
	"17,0,1,W:9,S:25,0",
	"18,0,1,W:10,S:26,0",
	"19,0,1,W:11,S:27,0",
	"20,1,0,L:1,L:6,0",
	"21,1,0,L:2,L:5,0",
	"22,1,0,L:3,L:4,0",
	"23,1,1,L:7,L:19,0",
	"24,1,1,L:8,L:18,0",
	"25,1,1,L:9,L:17,0",
	"26,1,1,L:10,L:16,0",
	"27,1,1,L:11,L:15,0",
	"28,1,1,W:20,L:12,0",
	"29,1,1,W:21,L:13,0",
	"30,1,1,W:22,W:14,0",
	"31,0,2,W:12,W:13,0",
	"32,0,2,W:14,W:15,0",
	"33,0,2,W:16,W:17,0",
	"34,0,2,W:18,W:19,0",
	"35,1,2,W:23,W:24,0",
	"36,1,2,W:25,W:26,0",
	"37,1,2,W:27,W:28,0",
	"38,1,2,W:29,W:30,0",
	"39,1,3,L:31,W:35,0",
	"40,1,3,L:32,W:36,0",
	"41,1,3,L:33,W:37,0",
	"42,1,3,L:34,W:38,0",
	"43,0,3,W:31,W:32,0",
	"44,0,3,W:33,W:34,0",
	"45,1,4,W:39,W:40,0",
	"46,1,4,W:41,W:42,0",
	"47,1,5,L:43,W:45,0",
	"48,1,5,L:44,W:46,0",
	"49,0,4,W:43,W:44,0",
	"50,1,6,W:47,W:48,0",
	"51,1,7,L:49,W:50,0",
	"52,0,5,W:50,W:51,1",
	"53,0,6,W:52,L:52,2"
];

$seed_de_28 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,0,S:11,S:12,0",
	"7,0,0,S:13,S:14,0",
	"8,0,0,S:15,S:16,0",
	"9,0,0,S:17,S:18,0",
	"10,0,0,S:19,S:20,0",
	"11,0,0,S:21,S:22,0",
	"12,0,0,S:23,S:24,0",
	"13,0,1,W:1,W:2,0",
	"14,0,1,W:3,W:4,0",
	"15,0,1,W:5,W:6,0",
	"16,0,1,W:7,W:8,0",
	"17,0,1,W:9,S:25,0",
	"18,0,1,W:10,S:26,0",
	"19,0,1,W:11,S:27,0",
	"20,0,1,W:12,S:28,0",
	"21,1,0,L:1,L:8,0",
	"22,1,0,L:2,L:7,0",
	"23,1,0,L:3,L:6,0",
	"24,1,0,L:4,L:5,0",
	"25,1,1,L:9,L:20,0",
	"26,1,1,L:10,L:19,0",
	"27,1,1,L:11,L:18,0",
	"28,1,1,L:12,L:17,0",
	"29,1,1,W:21,L:13,0",
	"30,1,1,W:22,L:14,0",
	"31,1,1,W:23,L:15,0",
	"32,1,1,W:24,L:16,0",
	"33,0,2,W:13,W:14,0",
	"34,0,2,W:15,W:16,0",
	"35,0,2,W:17,W:18,0",
	"36,0,2,W:19,W:20,0",
	"37,1,2,W:25,W:26,0",
	"38,1,2,W:27,W:28,0",
	"39,1,2,W:29,W:30,0",
	"40,1,2,W:31,W:32,0",
	"41,1,3,L:33,W:37,0",
	"42,1,3,L:34,W:38,0",
	"43,1,3,L:35,W:39,0",
	"44,1,3,L:36,W:40,0",
	"45,0,3,W:33,W:34,0",
	"46,0,3,W:35,W:36,0",
	"47,1,4,W:41,W:42,0",
	"48,1,4,W:43,W:44,0",
	"49,1,5,L:45,W:47,0",
	"50,1,5,L:46,W:48,0",
	"51,0,4,W:45,W:46,0",
	"52,1,6,W:49,W:50,0",
	"53,1,7,L:51,W:52,0",
	"54,0,5,W:51,W:53,1",
	"55,0,6,W:54,L:54,2"
];

$seed_de_29 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,0,S:11,S:12,0",
	"7,0,0,S:13,S:14,0",
	"8,0,0,S:15,S:16,0",
	"9,0,0,S:17,S:18,0",
	"10,0,0,S:19,S:20,0",
	"11,0,0,S:21,S:22,0",
	"12,0,0,S:23,S:24,0",
	"13,0,0,S:25,S:26,0",
	"14,0,1,W:1,W:2,0",
	"15,0,1,W:3,W:4,0",
	"16,0,1,W:5,W:6,0",
	"17,0,1,W:7,W:8,0",
	"18,0,1,W:9,W:10,0",
	"19,0,1,W:11,S:27,0",
	"20,0,1,W:12,S:28,0",
	"21,0,1,W:13,S:29,0",
	"22,1,0,L:1,L:10,0",
	"23,1,0,L:2,L:9,0",
	"24,1,0,L:3,L:8,0",
	"25,1,0,L:4,L:7,0",
	"26,1,0,L:5,L:6,0",
	"27,1,1,L:11,L:21,0",
	"28,1,1,L:12,L:20,0",
	"29,1,1,L:13,L:19,0",
	"30,1,1,W:22,L:14,0",
	"31,1,1,W:23,L:15,0",
	"32,1,1,W:24,L:16,0",
	"33,1,1,W:25,L:17,0",
	"34,1,1,W:26,L:18,0",
	"35,0,2,W:14,W:15,0",
	"36,0,2,W:16,W:17,0",
	"37,0,2,W:18,W:19,0",
	"38,0,2,W:20,W:21,0",
	"39,1,2,W:27,W:28,0",
	"40,1,2,W:29,W:30,0",
	"41,1,2,W:31,W:32,0",
	"42,1,2,W:33,W:34,0",
	"43,1,3,L:35,W:39,0",
	"44,1,3,L:36,W:40,0",
	"45,1,3,L:37,W:41,0",
	"46,1,3,L:38,W:42,0",
	"47,0,3,W:35,W:36,0",
	"48,0,3,W:37,W:38,0",
	"49,1,4,W:43,W:44,0",
	"50,1,4,W:45,W:46,0",
	"51,1,5,L:47,W:49,0",
	"52,1,5,L:48,W:50,0",
	"53,0,4,W:47,W:48,0",
	"54,1,6,W:51,W:52,0",
	"55,1,7,L:53,W:54,0",
	"56,0,5,W:53,W:55,1",
	"57,0,6,W:56,L:56,2"
];

$seed_de_30 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,0,S:11,S:12,0",
	"7,0,0,S:13,S:14,0",
	"8,0,0,S:15,S:16,0",
	"9,0,0,S:17,S:18,0",
	"10,0,0,S:19,S:20,0",
	"11,0,0,S:21,S:22,0",
	"12,0,0,S:23,S:24,0",
	"13,0,0,S:25,S:26,0",
	"14,0,0,S:27,S:28,0",
	"15,0,1,W:1,W:2,0",
	"16,0,1,W:3,W:4,0",
	"17,0,1,W:5,W:6,0",
	"18,0,1,W:7,W:8,0",
	"19,0,1,W:9,W:10,0",
	"20,0,1,W:11,W:12,0",
	"21,0,1,W:13,S:29,0",
	"22,0,1,W:14,S:30,0",
	"23,1,0,L:1,L:12,0",
	"24,1,0,L:2,L:11,0",
	"25,1,0,L:3,L:10,0",
	"26,1,0,L:4,L:9,0",
	"27,1,0,L:5,L:8,0",
	"28,1,0,L:6,L:7,0",
	"29,1,1,L:13,L:22,0",
	"30,1,1,L:14,L:21,0",
	"31,1,1,W:23,L:15,0",
	"32,1,1,W:24,L:16,0",
	"33,1,1,W:25,L:17,0",
	"34,1,1,W:26,L:18,0",
	"35,1,1,W:27,L:19,0",
	"36,1,1,W:28,L:20,0",
	"37,0,2,W:15,W:16,0",
	"38,0,2,W:17,W:18,0",
	"39,0,2,W:19,W:20,0",
	"40,0,2,W:21,W:22,0",
	"41,1,2,W:29,W:30,0",
	"42,1,2,W:31,W:32,0",
	"43,1,2,W:33,W:34,0",
	"44,1,2,W:35,W:36,0",
	"45,1,3,L:37,W:41,0",
	"46,1,3,L:38,W:42,0",
	"47,1,3,L:39,W:43,0",
	"48,1,3,L:40,W:44,0",
	"49,0,3,W:37,W:38,0",
	"50,0,3,W:39,W:40,0",
	"51,1,4,W:45,W:46,0",
	"52,1,4,W:47,W:48,0",
	"53,1,5,L:49,W:51,0",
	"54,1,5,L:50,W:52,0",
	"55,0,4,W:49,W:50,0",
	"56,1,6,W:53,W:54,0",
	"57,1,7,L:55,W:56,0",
	"58,0,5,W:55,W:57,1",
	"59,0,6,W:58,L:58,2"
];

$seed_de_31 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,0,S:11,S:12,0",
	"7,0,0,S:13,S:14,0",
	"8,0,0,S:15,S:16,0",
	"9,0,0,S:17,S:18,0",
	"10,0,0,S:19,S:20,0",
	"11,0,0,S:21,S:22,0",
	"12,0,0,S:23,S:24,0",
	"13,0,0,S:25,S:26,0",
	"14,0,0,S:27,S:28,0",
	"15,0,0,S:29,S:30,0",
	"16,0,1,W:1,W:2,0",
	"17,0,1,W:3,W:4,0",
	"18,0,1,W:5,W:6,0",
	"19,0,1,W:7,W:8,0",
	"20,0,1,W:9,W:10,0",
	"21,0,1,W:11,W:12,0",
	"22,0,1,W:13,W:14,0",
	"23,0,1,W:15,S:31,0",
	"24,1,0,L:1,L:14,0",
	"25,1,0,L:2,L:13,0",
	"26,1,0,L:3,L:12,0",
	"27,1,0,L:4,L:11,0",
	"28,1,0,L:5,L:10,0",
	"29,1,0,L:6,L:9,0",
	"30,1,0,L:7,L:8,0",
	"31,1,1,L:15,L:23,0",
	"32,1,1,W:24,L:16,0",
	"33,1,1,W:25,L:17,0",
	"34,1,1,W:26,L:18,0",
	"35,1,1,W:27,L:19,0",
	"36,1,1,W:28,L:20,0",
	"37,1,1,W:29,L:21,0",
	"38,1,1,W:30,L:22,0",
	"39,0,2,W:16,W:17,0",
	"40,0,2,W:18,W:19,0",
	"41,0,2,W:20,W:21,0",
	"42,0,2,W:22,W:23,0",
	"43,1,2,W:31,W:32,0",
	"44,1,2,W:33,W:34,0",
	"45,1,2,W:35,W:36,0",
	"46,1,2,W:37,W:38,0",
	"47,1,3,L:39,W:43,0",
	"48,1,3,L:40,W:44,0",
	"49,1,3,L:41,W:45,0",
	"50,1,3,L:42,W:46,0",
	"51,0,3,W:39,W:40,0",
	"52,0,3,W:41,W:42,0",
	"53,1,4,W:47,W:48,0",
	"54,1,4,W:49,W:50,0",
	"55,1,5,L:51,W:53,0",
	"56,1,5,L:52,W:54,0",
	"57,0,4,W:51,W:52,0",
	"58,1,6,W:55,W:56,0",
	"59,1,7,L:57,W:58,0",
	"60,0,5,W:57,W:59,1",
	"61,0,6,W:60,L:60,2"
];

$seed_de_32 = [
	"1,0,0,S:1,S:2,0",
	"2,0,0,S:3,S:4,0",
	"3,0,0,S:5,S:6,0",
	"4,0,0,S:7,S:8,0",
	"5,0,0,S:9,S:10,0",
	"6,0,0,S:11,S:12,0",
	"7,0,0,S:13,S:14,0",
	"8,0,0,S:15,S:16,0",
	"9,0,0,S:17,S:18,0",
	"10,0,0,S:19,S:20,0",
	"11,0,0,S:21,S:22,0",
	"12,0,0,S:23,S:24,0",
	"13,0,0,S:25,S:26,0",
	"14,0,0,S:27,S:28,0",
	"15,0,0,S:29,S:30,0",
	"16,0,0,S:31,S:32,0",
	"17,0,1,W:1,W:2,0",
	"18,0,1,W:3,W:4,0",
	"19,0,1,W:5,W:6,0",
	"20,0,1,W:7,W:8,0",
	"21,0,1,W:9,W:10,0",
	"22,0,1,W:11,W:12,0",
	"23,0,1,W:13,W:14,0",
	"24,0,1,W:15,W:16,0",
	"25,1,0,L:1,L:16,0",
	"26,1,0,L:2,L:15,0",
	"27,1,0,L:3,L:14,0",
	"28,1,0,L:4,L:13,0",
	"29,1,0,L:5,L:12,0",
	"30,1,0,L:6,L:11,0",
	"31,1,0,L:7,L:10,0",
	"32,1,0,L:8,L:9,0",
	"33,1,1,L:17,W:25,0",
	"34,1,1,L:18,W:26,0",
	"35,1,1,L:19,W:27,0",
	"36,1,1,L:20,W:28,0",
	"37,1,1,L:21,W:29,0",
	"38,1,1,L:22,W:30,0",
	"39,1,1,L:23,W:31,0",
	"40,1,1,L:24,W:32,0",
	"41,0,2,W:17,W:18,0",
	"42,0,2,W:19,W:20,0",
	"43,0,2,W:21,W:22,0",
	"44,0,2,W:23,W:24,0",
	"45,1,2,W:33,W:34,0",
	"46,1,2,W:35,W:36,0",
	"47,1,2,W:37,W:38,0",
	"48,1,2,W:39,W:40,0",
	"49,1,3,L:41,W:45,0",
	"50,1,3,L:42,W:46,0",
	"51,1,3,L:43,W:47,0",
	"52,1,3,L:44,W:48,0",
	"53,0,3,W:41,W:42,0",
	"54,0,3,W:43,W:44,0",
	"55,1,4,W:49,W:50,0",
	"56,1,4,W:51,W:52,0",
	"57,1,5,L:53,W:55,0",
	"58,1,5,L:54,W:56,0",
	"59,0,4,W:53,W:54,0",
	"60,1,6,W:57,W:58,0",
	"61,1,7,L:59,W:60,0",
	"62,0,5,W:59,W:61,1",
	"63,0,6,W:62,L:62,2"
];

$round_desc_single = [
	4=>$rd_se_4,
	5=>$rd_se_5_8,
	6=>$rd_se_5_8,
	7=>$rd_se_5_8,
	8=>$rd_se_5_8,
	9=>$rd_se_9_16,
	10=>$rd_se_9_16,
	11=>$rd_se_9_16,
	12=>$rd_se_9_16,
	13=>$rd_se_9_16,
	14=>$rd_se_9_16,
	15=>$rd_se_9_16,
	16=>$rd_se_9_16,
	17=>$rd_se_17_32,
	18=>$rd_se_17_32,
	19=>$rd_se_17_32,
	20=>$rd_se_17_32,
	21=>$rd_se_17_32,
	22=>$rd_se_17_32,
	23=>$rd_se_17_32,
	24=>$rd_se_17_32,
	25=>$rd_se_17_32,
	26=>$rd_se_17_32,
	27=>$rd_se_17_32,
	28=>$rd_se_17_32,
	29=>$rd_se_17_32,
	30=>$rd_se_17_32,
	31=>$rd_se_17_32,
	32=>$rd_se_17_32,
];

$round_desc_double = [
	4=>$rd_de_4,
	5=>$rd_de_5_6,
	6=>$rd_de_5_6,
	7=>$rd_de_7_8,
	8=>$rd_de_7_8,
	9=>$rd_de_9_12,
	10=>$rd_de_9_12,
	11=>$rd_de_9_12,
	12=>$rd_de_9_12,
	13=>$rd_de_13_16,
	14=>$rd_de_13_16,
	15=>$rd_de_13_16,
	16=>$rd_de_13_16,
	17=>$rd_de_17_24,
	18=>$rd_de_17_24,
	19=>$rd_de_17_24,
	20=>$rd_de_17_24,
	21=>$rd_de_17_24,
	22=>$rd_de_17_24,
	23=>$rd_de_17_24,
	24=>$rd_de_17_24,
	25=>$rd_de_25_32,
	26=>$rd_de_25_32,
	27=>$rd_de_25_32,
	28=>$rd_de_25_32,
	29=>$rd_de_25_32,
	30=>$rd_de_25_32,
	31=>$rd_de_25_32,
	32=>$rd_de_25_32,
];

$seeds_single = [
	4=>$seed_se_4,
	5=>$seed_se_5,
	6=>$seed_se_6,
	7=>$seed_se_7,
	8=>$seed_se_8,
	9=>$seed_se_9,
	10=>$seed_se_10,
	11=>$seed_se_11,
	12=>$seed_se_12,
	13=>$seed_se_13,
	14=>$seed_se_14,
	15=>$seed_se_15,
	16=>$seed_se_16,
	17=>$seed_se_17,
	18=>$seed_se_18,
	19=>$seed_se_19,
	20=>$seed_se_20,
	21=>$seed_se_21,
	22=>$seed_se_22,
	23=>$seed_se_23,
	24=>$seed_se_24,
	25=>$seed_se_25,
	26=>$seed_se_26,
	27=>$seed_se_27,
	28=>$seed_se_28,
	29=>$seed_se_29,
	30=>$seed_se_30,
	31=>$seed_se_31,
	32=>$seed_se_32,
];

$seeds_double = [
	4=>$seed_de_4,
	5=>$seed_de_5,
	6=>$seed_de_6,
	7=>$seed_de_7,
	8=>$seed_de_8,
	9=>$seed_de_9,
	10=>$seed_de_10,
	11=>$seed_de_11,
	12=>$seed_de_12,
	13=>$seed_de_13,
	14=>$seed_de_14,
	15=>$seed_de_15,
	16=>$seed_de_16,
	17=>$seed_de_17,
	18=>$seed_de_18,
	19=>$seed_de_19,
	20=>$seed_de_20,
	21=>$seed_de_21,
	22=>$seed_de_22,
	23=>$seed_de_23,
	24=>$seed_de_24,
	25=>$seed_de_25,
	26=>$seed_de_26,
	27=>$seed_de_27,
	28=>$seed_de_28,
	29=>$seed_de_29,
	30=>$seed_de_30,
	31=>$seed_de_31,
	32=>$seed_de_32,
];

?>