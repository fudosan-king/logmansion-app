import 'package:flutter_bloc/flutter_bloc.dart';
import '../../repositories/catalog_repository.dart';
import 'catalog_event.dart';
import 'catalog_state.dart';

class CatalogBloc extends Bloc<CatalogEvent, CatalogState> {
  final CatalogRepository catalogRepository;

  CatalogBloc(this.catalogRepository) : super(CatalogInitial()) {
    on<FetchCatalogs>(_onFetchCatalogs);
    on<RefreshCatalogs>(_onRefreshCatalogs);
  }

  Future<void> _onFetchCatalogs(
      FetchCatalogs event,
      Emitter<CatalogState> emit,
      ) async {
    emit(CatalogLoading());
    try {
      final catalogs = await catalogRepository.fetchCatalogs();
      emit(CatalogLoaded(catalogs));
    } catch (e) {
      emit(CatalogError(e.toString()));
    }
  }

  Future<void> _onRefreshCatalogs(
      RefreshCatalogs event,
      Emitter<CatalogState> emit,
      ) async {
    try {
      final catalogs = await catalogRepository.fetchCatalogs();
      emit(CatalogLoaded(catalogs));
    } catch (e) {
      emit(CatalogError(e.toString()));
    }
  }
}
