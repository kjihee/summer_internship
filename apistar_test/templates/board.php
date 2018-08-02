<?php

	require_once("./dbconfig.php");

?>

<!DOCTYPE html>

<html>

<head>

	<meta charset="utf-8" />

	<title> test_video_management</title>

	<link rel="stylesheet" href="./css/normalize.css" />

	<link rel="stylesheet" href="./css/board.css" />

</head>

<body>

	<article class="boardArticle">

		<h3>자유게시판</h3>

		<table>

			<caption class="readHide">자유게시판</caption>

			<thead>

				<tr>

					<th scope="col" class="no">번호</th>

					<th scope="col" class="title">제목</th>

					<th scope="col" class="author">작성자</th>

					<th scope="col" class="date">작성일</th>

					<th scope="col" class="hit">조회</th>

				</tr>

			</thead>

			<tbody>

					<?php

						$sql = 'select * from wp_kboard_content order by uid desc';

						$result = $db->query($sql);

						while($row = $result->fetch_assoc())

						{

							$datetime = explode(' ', $row['date']);

							$date = $datetime[0];

							$time = $datetime[1];

							if($date == Date('Y-m-d'))

								$row['date'] = $time;

							else

								$row['date'] = $date;

					?>

				<tr>

					<td class="no"><?php echo $row['uid']?></td>

					<td class="title"><?php echo $row['title']?></td>

					<td class="author"><?php echo $row['member_display']?></td>

					<td class="date"><?php echo $row['date']?></td>

					<td class="hit"><?php echo $row['view']?></td>

				</tr>

					<?php

						}

					?>

			</tbody>

		</table>

	</article>

</body>

</html>
