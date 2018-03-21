<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/9
 * Time: 15:46
 */
?>
<script>
    function test(){
        var oriData = [
            0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0.005,0.017,0.017,0.017,0.017,0.011,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0.021,0.026,0.03,0.036,0.036,0.195,0.221,0.019,0.013,0.017,0.03,0.03,0.03,0.046,0.045,0.038,0.084,0.045,0.045,0.037,0.034,0.035,0.036,0.044,0.052,0.048,0.109,0.033,0.029,0.04,0.042,0.042,0.042,0.073,0.076,0.062,0.066,0.066,0.075,0.096,0.128,0.121,0.128,0.14,0.226,0.143,0.097,0.018,0,0,0,0,0,0.018,0.047,0.054,0.054,0.054,0.036,0.185,0.009,0.038,0.061,0.077,0.091,0.126,0.69,0.182,0.349,0.231,0.146,0.128,0.167,0.1,0.075,0.071,0.071,0.117,0.01,0.002,0.002,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0.005,0.026,0.038,0.038,0.038,0.076,0.086,0.109,0.213,0.276,0.288,0.297,0.642,1.799,1.236,2.138,0.921,0.497,0.685,0.828,0.41,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0.018,0.024,0.024,0.024,0.024,0.006,0.003,0.046,0.046,0.046,0.046,0.043,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0.204,0.303,1.028,1.328,1.524,1.41,1.362,1.292,1.191,0.529,0.501,0.944,1.81,2.899,0.859,0.126,0.087,0.047,0,0,0,0,0.011,0.028,0.028,0.028,0.028,0.017,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0.099,0.159,0.297,0.309,0.309,0.614,0.818,1.436,1.195,0.553,0.542,0.955,0.898,0.466,0.386,0.556,0.388,0.221,0.192,0.192,0.187,0.166,0.18,0.302,0.158,0.009,0.009,0.009,0.009,0.009,0.007,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0.004,0.032,0.032,0.032,0.032,0.082,0.149,0.204,0.247,0.262,0.49,0.51,0.533,0.746,0.847,2.393,1.188,1.114,0.475,0.043,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0.017,0.017,0.021,0.042,0.079,0.111,0.126,0.122,0.133,0.846,0.102,0.077,0.067,0.056,0.005,0,0,0,0,0,0,0,0,0,0,0,0,0,0.011,0.017,0.017,0.017,0.017,0.006,0,0,0,0,0,0.01,0.03,0.054,0.067,0.07,0.25,0.251,0.494,0.065,0.054,0.054,0.064,0.084,0.077,0.101,0.132,0.248,0.069,0.117,0.115,0.087,0.326,0.036,0.009,0.009,0.009,0.009,0.009,0.004,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0.02,0.039,0.04,0.04,0.04,0.229,0.079,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0.023,0.069,0.082,0.082,0.082,0.503,0.774,0.038,0.012,0.012,0.012,0.016,0.02,0.028,0.051,0.06,0.064,0.19,0.15,0.164,0.139,0.13,0.085,0.031,0.023,0.022,0.007,0.005,0.005,0.001,0,0.02,0.048,0.048,0.053,0.056,0.036,0.008,0.008,0.004,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0.013,0.017,0.036,0.068,0.095,0.233,0.272,0.377,0.722,1.494,3.756,0.954,0.439,0.442,0.462,0.373,0.249,0.214,0.1,0.044,0.037,0.023,0.002,0,0,0,0,0,0,0.02,0.024,0.024,0.024,0.024,0.004,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0.008,0.017,0.017,0.045,0.186,0.308,0.241,0.241,0.893,4.067,4.494,5.015,3.494,2.057,1.411,0.718,0.407,0.313,0.339,1.537,1.105,0.218,0.136,0.03,0.005,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0.037,0.448,1.2,1.309,1.309,1.425,1.223,0.471,0.767,0.423,0.273,0.412,0.646,0.481,0.239,0.131,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0.044,0.15,0.223,0.388,0.513,0.883,2.828,4.786,5.959,4.95,6.434,6.319,3.35,2.806,4.204,1.395,1.015,1.015,0.836,0.74,0.72,0.615,0.477,0.192,0.046,0.007,0.007,0.007,0.007,0.007,0.007,0.007,0.008,0.005,0.005,0.005,0.005,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0.001,0.012,0.012,0.012,0.012,0.011,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0.002,0.012,0.028,0.028,0.028,0.138,0.092,0.082,0.082,0.096,0.719,0.155,0.042,0.047,0.129,0.021,0.021,0.014,0.009,0.029,0.067,0.088,0.095,0.095,0.138,0.091,0.032,0.025,0.025,0.003,0,0,0,0,0,0,0,0,0,0,0,0,0.002,0.045,0.228,0.297,0.325,0.339,0.581,1.244,0.796,0.517,0.227,0.053,0.006,0,0,0,0,0,0,0,0,0,0.003,0.005,0.005,0.005,0.005,0.081,0.129,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0.014,0.041,0.041,0.041,0.041,0.027,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0.009,0.017,0.017,0.017,0.017,0.355,0.174,0.009,0.009,0.012,0.136,0.208,0.208,0.208,0.215,7.359,1.858,0.458,0.053,0.053,0.047,0.045,0.045,0.059,0.136,0.188,0.206,0.21,0.588,1.517,6.02,4.688,4.42,0.624,0.326,0.359,0.553,0.899,0.94,2.95,9.415,5.752,1.092,0.096,0.035,0.026,0.018,0.015,0.011,0.011,0.011,0,0,0,0,0,0,0,0,0,0,0,0.056,0.27,0.314,0.351,0.354,0.609,0.796,1.857,0.848,0.538,0.214,0.178,0.178,0.201,0.231,0.227,0.272,0.397,0.45,1.014,2.917,1.675,0.081,0.059,0.059,0.148,0.075,0.075,0.078,0.236,0.784,0.784,0.784,0.784,0.741,0.115,0.058,0.058,0.058,0.029,0.015,0.015,0.015,0.015,0.012,0.008,0.604,0.985,1.305,2.273,2.528,2.336,2.496,2.281,1.397,1.713,3.259,1.167,0.745,0.548,1.058,0.684,0.728,0.392,0.179,0.283,0.283,0.46,0.08,0.099,0.099,0.099,0.1,0.143,0.137,0.238,0.317,0.262,0.225,0.792,0.426,0.332,0.261,0.11,0.093,0.102,0.171,0.292,0.504,0.605,1.745,2.485,1.964,0.33,0.171,0.259,0.242,0.215,0.366,0.354,0.205,0.203,0.262,0.153,0.13,0.137,0.362,0.691,0.295,0.433,0.154,0.056,0.053,0.053,0.053,0.051,0.047,0.065,0.078,0.091,0.206,0.813,0.102,0.151,0.05,0.024,0.004,0.001,0,0,0,0.021,0.021,0.021,0.021,0.021,0.013,0.013,0.013,0.013,0.013,0.013,0.013,0.013,0.01,0.01,0.01,0.01,0.01,0.01,0.01,0.01,0.01,0.01,0.008,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0.018,0.021,0.021,0.021,0.021,0.003,0,0,0,0,0,0,0,0,0,0.024,0.173,0.261,0.267,0.267,0.534,1.354,1.772,0.72,0.218,0.018,0.018,0.028,0.036,0.032,0.194,0.082,0.035,0.286,0.027,0.038,0.038,0.027,0.021,0.014,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0.016,0.017,0.017,0.031,0.047,0.043,0.056,0.104,0.149,0.179,0.205,0.328,0.998,0.522,1.851,3.727,3.273,2.204,1.169,1.006,1.179,0.74,0.741,1.065,0.925,0.671,0.497,0.431,0.327,0.277,0.126,0.581,0.207,0.359,2.485,0.038,0.036,0.003,0.003,0.003,0.003,0.004,0.098,0.023,0.021,0.021,0.022,0.041,0.041,0.043,0.045,0.043,0.014,0.014,0.014,0.014,0.014,0.014,0.014,0.031,0.046,0.063,0.119,0.107,0.092,0.085,0.065,0.06,0.054,0.042,0.039,0.046,0.044,0.028,0.028,0.02,0.013,0.013,0.013,0.013,0.016,0.032,0.031,0.031,0.031,0.028,0.011,0.011,0.011,0.011,0.011,0.023,0.024,0.024,0.024,0.019,0.015,0.015,0.015,0.015,0.015,0.015,0.013,0.01,0.01,0.01,0.01,0.01,0.01,0.01,0.01,0.01,0.01,0.001,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0.011,0.017,0.024,0.026,0.061,0.172,0.206,0.213,0.267,0.511,0.668,0.157,0.017,0.017,0.017,0.046,0.054,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0.001,0.017,0.017,0.017,0.017,0.016,0,0,0,0,0,0,0,0,0,0.01,0.017,0.017,0.017,0.017,0.012,0.017,0.017,0.017,0.017,0.012,0,0,0,0,0,0.003,0.031,0.066,0.093,0.112,0.122,0.202,0.068,0.041,0.022,0.011,0,0,0,0,0,0,0,0,0,0,0,0.002,0.005,0.012,0.021,0.021,0.019,0.033,0.03,0.026,0.026,0.034,0.095,0.024,0.024,0.024,0.023,0.019,0.018,0.018,0.018,0.011,0.03,0.045,0.044,0.044,0.044,0.022,0.009,0.024,0.033,0.033,0.033,0.024,0.009,0,0,0,0,0,0,0.003,0.017,0.017,0.017,0.017,0.014,0,0,0,0,0,0.032,0.032,0.032,0.032,0.032,0.005,0.008,0.009,0.014,0.014,0.009,0.005,0.004,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0.007,0.009,0.009,0.009,0.009,0.043,0.063,0.084,0.098,0.101,0.213,0.334,0.383,0.43,0.448,0.511,0.801,0.835,1.642,1.614,1.496,1.496,1.476,1.068,0.481,0.22,0.119,0.099,0.07,0.072,0.063,0.076,0.14,0.205,0.28,0.297,0.3,0.479,0.877,1.098,1.611,1.629,1.686,1.686,1.631,1.528,1.862,1.703,1.531,2.196,0.395,0.416,0.453,0.728,0.917,0.986,1.17,2.171,3.011,2.909,3.301,1.377,0.778,0.799,0.947,1.039,0.879,0.76,1.372,1.674,1.674,1.68,1.823,1.793,1.162,0.783,0.216,0.152,0.152,0.152,0.049,0,0,0,0.117,0.127,0.127,0.127,0.127,0.127,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0.003,0.005,0.005,0.005,0.005,0.003,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0.309,0.364,0.364,0.364,0.364,0.063,0.01,0.01,0.01,0.012,0.015,0.015,0.11,0.55,0.824,0.825,0.829,1.39,1.429,1.342,1.43,1.636,1.717,2.135,2.203,3.191,3.022,1.589,0.86,0.807,0.645,0.595,0.588,0.557,0.552,1.271,0.708,0.677,0.629,0.714,0.203,0.133,0.061,0.062,0.018,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0.001,0.072,0.29,0.438,0.53,0.557,0.873,1.039,1.04,0.208,0.049,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0.03,0.039,0.039,0.039,0.039,0.098,0.008,0.007,0.007,0.007,0.007,0.007,0.007,0.007,0.007,0.007,0.056,0.062,0.065,0.065,0.065,0.047,0.216,0.256,0.315,0.4,0.502,0.449,0.47,0.571,0.814,1.153,0.774,0.202,0.086,0.075,0.071,0.032,0.019,0.003,0.004,0.004,0.004,0.004,0.004,0.004,0.007,0.072,0.153,0.256,0.306,0.404,0.698,0.733,0.823,0.715,0.563,0.404,0.293,0.217,0.213,0.202,0.202,0.294,0.704,0.797,1.359,1.101,0.72,0.514,0.539,0.434,0.389,0.387,0.386,0.375,0.369,0.319,0.239,0.183,0.136,0.062,0.052,0.096,0.119,0.119,0.114,0.127,0.132,0.139,0.169,0.191,0.278,0.254,0.214,0.237,0.221,0.143,0.129,0.125,0.109,0.1,0.087,0.06,0.038,0.029,0.029,0.028,0.048,0.053,0.053,0.111,0.125,0.102,0.097,0.097,0.039,0.02,0.02,0.02,0.014,0.004,0.031,0.043,0.047,0.052,0.08,0.144,0.182,0.176,0.171,0.149,0.112,0.025,0,0,0,0,0,0,0,0.016,0.031,0.031,0.031,0.031,0.015,0,0,0,0,0,0.005,0.005,0.005,0.005,0.005,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0.005,0.005,0.005,0.005,0.005,0.001,0,0,0
        ];
        var len = oriData.length;
        while(len--) {
            oriData[len] *= -1;
        }
        return oriData;
    }

</script>