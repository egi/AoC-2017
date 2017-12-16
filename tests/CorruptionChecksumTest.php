<?php

use PHPUnit\Framework\TestCase;

require_once('src/CorruptionChecksum.php');

class CorruptionChecksumTest extends TestCase {
    public function testCase1()
    {
        $o = new CorruptionChecksum();
        $o->addRow('5	1	9	5');
        $o->addRow('7	5	3');
        $o->addRow('2	4	6	8');
        $this->assertEquals(18, $o->getChecksum());
    }
    public function testCase2()
    {
        $o = new CorruptionChecksum();
        $o->setStrategy('evenlyDivisible');
        $o->addRow("5\t9\t2\t8");
        $o->addRow("9\t4\t7\t3");
        $o->addRow("3\t8\t6\t5");
        $this->assertEquals(9, $o->getChecksum());
    }
    private function addFinalRows(&$o) {
        $o->addRow('86	440	233	83	393	420	228	491	159	13	110	135	97	238	92	396');
        $o->addRow('3646	3952	3430	145	1574	2722	3565	125	3303	843	152	1095	3805	134	3873	3024');
        $o->addRow('2150	257	237	2155	1115	150	502	255	1531	894	2309	1982	2418	206	307	2370');
        $o->addRow('1224	343	1039	126	1221	937	136	1185	1194	1312	1217	929	124	1394	1337	168');
        $o->addRow('1695	2288	224	2667	2483	3528	809	263	2364	514	3457	3180	2916	239	212	3017');
        $o->addRow('827	3521	127	92	2328	3315	1179	3240	695	3144	3139	533	132	82	108	854');
        $o->addRow('1522	2136	1252	1049	207	2821	2484	413	2166	1779	162	2154	158	2811	164	2632');
        $o->addRow('95	579	1586	1700	79	1745	1105	89	1896	798	1511	1308	1674	701	60	2066');
        $o->addRow('1210	325	98	56	1486	1668	64	1601	1934	1384	69	1725	992	619	84	167');
        $o->addRow('4620	2358	2195	4312	168	1606	4050	102	2502	138	135	4175	1477	2277	2226	1286');
        $o->addRow('5912	6261	3393	431	6285	3636	4836	180	6158	6270	209	3662	5545	204	6131	230');
        $o->addRow('170	2056	2123	2220	2275	139	461	810	1429	124	1470	2085	141	1533	1831	518');
        $o->addRow('193	281	2976	3009	626	152	1750	1185	3332	715	1861	186	1768	3396	201	3225');
        $o->addRow('492	1179	154	1497	819	2809	2200	2324	157	2688	1518	168	2767	2369	2583	173');
        $o->addRow('286	2076	243	939	399	451	231	2187	2295	453	1206	2468	2183	230	714	681');
        $o->addRow('3111	2857	2312	3230	149	3082	408	1148	2428	134	147	620	128	157	492	2879');
    }
    public function testFinal()
    {
        $o = new CorruptionChecksum();
        $this->addFinalRows($o);
        $this->assertEquals(45158, $o->getChecksum());
    }
    public function testFinal2()
    {
        $o = new CorruptionChecksum();
        $o->setStrategy('evenlyDivisible');
        $this->addFinalRows($o);
        $this->assertEquals(294, $o->getChecksum());
    }
}
