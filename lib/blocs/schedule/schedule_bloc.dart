import 'package:flutter_bloc/flutter_bloc.dart';
import '../../repositories/schedule_repository.dart';
import 'schedule_event.dart';
import 'schedule_state.dart';

class ScheduleBloc extends Bloc<ScheduleEvent, ScheduleState> {
  final ScheduleRepository scheduleRepository;

  ScheduleBloc(this.scheduleRepository) : super(ScheduleInitial()) {
    on<FetchSchedules>(_onFetchSchedules);
  }

  Future<void> _onFetchSchedules(
      FetchSchedules event,
      Emitter<ScheduleState> emit,
      ) async {
    emit(ScheduleLoading());
    try {
      final schedules = await scheduleRepository.fetchSchedules();
      schedules.removeWhere((schedule) => schedule.isDateBeforeToday());
      emit(ScheduleLoaded(schedules));
    } catch (e) {
      emit(ScheduleError(e.toString()));
    }
  }
}
