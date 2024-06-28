import 'package:equatable/equatable.dart';

class Schedule extends Equatable {
  final int id;
  final String name;
  final String description;
  final DateTime date;
  final int position;

  const Schedule({
    required this.id,
    required this.name,
    required this.description,
    required this.date,
    required this.position,
  });

  @override
  // TODO: implement props
  List<Object?> get props => [id, description];

  static  Schedule empty = Schedule(
    id: 0,
    description: '',
    name: '',
    date: DateTime.now(),
    position: 0,
  );

  factory Schedule.fromJson(Map<String, dynamic> json) {
    return Schedule(
      id: json['schedule_id'] ?? 0,
      name: json['schedule_name'] ?? "",
      description: json['schedule_description'] ?? "",
      date: DateTime.parse(json['schedule_date']),
      position: json['position'] ?? 0,
    );
  }

  bool isDateBeforeToday() {
    DateTime today = DateTime.now();
    DateTime todayDateOnly = DateTime(today.year, today.month, today.day);
    DateTime inputDateOnly = DateTime(date.year, date.month, date.day);
    return inputDateOnly.isBefore(todayDateOnly);
  }

}
