$stmt = $mysqli->prepare("
SELECT email, datestamp, exercise, sets, reps, weight
FROM workouts
");