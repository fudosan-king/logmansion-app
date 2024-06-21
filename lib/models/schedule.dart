import 'package:equatable/equatable.dart';

class Schedule extends Equatable {
  final String id;
  final String name;
  final String description;
  final String date;
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

  static const empty = Schedule(
    id: '',
    description: '',
    name: '',
    date: '',
    position: 0,
  );

  factory Schedule.fromJson(Map<String, dynamic> json) {
    return Schedule(
      id: json['schedule_id'] ?? "",
      name: json['schedule_name'] ?? "",
      description: json['schedule_description'] ?? "",
      date: json['schedule_date	'] ?? "",
      position: json['position'] ?? 0,
    );
  }
}
