<?php
// 启用错误报告，防止 PHP 出错导致白屏
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 获取用户输入
$protein_family = isset($_POST['protein_family']) ? $_POST['protein_family'] : 'myoglobin';
$taxonomic_group = isset($_POST['taxonomic_group']) ? $_POST['taxonomic_group'] : 'mammals';

// 构造 shell 命令
$python_script = "python3 pipeline.py " . escapeshellarg($protein_family) . " " . escapeshellarg($taxonomic_group);

// 运行 Python 命令，并捕获标准输出和错误信息
$output = shell_exec($python_script);

// 显示调试信息
echo "<h2>Test Python Execution</h2>";
echo "<pre>";
echo "Command Executed: $python_script\n";
echo "Output:\n$output\n";
echo "</pre>";

// 额外测试 Python 是否可执行
echo "<h2>Testing Python Installation</h2>";
echo "<pre>";
echo "Python Path: " . shell_exec("which python3") . "\n";
echo "Python Version:\n" . shell_exec("python3 --version") . "\n";
echo "</pre>";
?>
