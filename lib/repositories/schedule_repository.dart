import 'dart:convert';
import 'package:http/http.dart' as http;
import '../models/schedule.dart';
import '../utils/domain.dart';

class ScheduleRepository {
  Future<List<Schedule>> fetchSchedules() async {
    try {
      List<Schedule> schedules = [];
      final response = await http.get(
        Uri.parse(Domain.getApiUrl("estate/view_schedule/2")),
      );
      if (response.statusCode == 200) {
        schedules = (json.decode(response.body)['data'] as List)
            .map((data) => Schedule.fromJson(data))
            .toList();
        schedules.sort((a, b) => a.position.compareTo(b.position));
        return schedules;
      } else {
        throw Exception('Failed to get schedules');
      }
    } catch (e) {
      throw Exception('Failed to get schedules');
    }
  }
}
